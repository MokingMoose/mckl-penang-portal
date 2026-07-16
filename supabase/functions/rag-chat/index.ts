// @ts-nocheck
import { serve } from "https://deno.land/std@0.168.0/http/server.ts";

const corsHeaders = {
  "Access-Control-Allow-Origin": "*",
  "Access-Control-Allow-Headers": "authorization, x-client-info, apikey, content-type",
};

serve(async (req) => {
  if (req.method === "OPTIONS") {
    return new Response("ok", { headers: corsHeaders });
  }

  try {
    const { action, input, question, context, history, imageBase64, mimeType, prompt } = await req.json();
    const geminiKey = Deno.env.get("GEMINI_API_KEY");
    if (!geminiKey) throw new Error("GEMINI_API_KEY secret is not set.");

    // ── ACTION: embed ──────────────────────────────────────────────────────────
    if (action === "embed") {
      const res = await fetch(
        `https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key=${geminiKey}`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            content: { parts: [{ text: input }] },
          }),
        }
      );
      if (!res.ok) {
        const errText = await res.text();
        throw new Error(`Gemini embed error ${res.status}: ${errText}`);
      }
      const json = await res.json();
      const embedding = json?.embedding?.values;
      if (!Array.isArray(embedding) || embedding.length === 0) {
        throw new Error("Gemini returned an empty embedding.");
      }
      return new Response(JSON.stringify({ embedding }), {
        headers: { ...corsHeaders, "Content-Type": "application/json" },
      });
    }

    // ── ACTION: vision ─────────────────────────────────────────────────────────
    // Reads a base64 image and returns structured text.
    // Used by the admin upload page to parse visual PDF timetables.
    if (action === "vision") {
      if (!imageBase64) throw new Error("imageBase64 is required for vision action.");

      const visionPrompt = prompt ||
        `Analyze this document image carefully.

If it contains a TIMETABLE or SCHEDULE with a grid layout:
- Identify all day rows (Monday/Tuesday/Wednesday/Thursday/Friday or Mo/Tu/We/Th/Fr)
- For each class block in the grid, determine its day AND time slot from its position in the grid
- Output strictly in this format:

[DAY NAME]
- [START TIME]-[END TIME]: [SUBJECT CODE], Room [ROOM], [LECTURER NAME]

Example:
TUESDAY
- 8:00-11:00: CSC1214, Room B201, Dr Ooi Ws
- 13:00-16:00: CSC1207, Room B201, Ms Jayashiry M

WEDNESDAY
- 13:00-16:00: CSC1213, Room B202, Dr Ooi Ws

If it is a REGULAR DOCUMENT (text, paragraphs, tables):
- Extract all text content in reading order
- Preserve headings, lists, and important structure

Output ONLY the extracted content, no commentary.`;

      const res = await fetch(
        `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${geminiKey}`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            contents: [{
              parts: [
                { inline_data: { mime_type: mimeType || "image/png", data: imageBase64 } },
                { text: visionPrompt },
              ],
            }],
            generationConfig: { maxOutputTokens: 2000, temperature: 0 },
          }),
        }
      );
      if (!res.ok) {
        const errText = await res.text();
        throw new Error(`Gemini vision error ${res.status}: ${errText}`);
      }
      const json = await res.json();
      const text = json?.candidates?.[0]?.content?.parts?.[0]?.text;
      if (!text) throw new Error("No text returned from Gemini Vision.");
      return new Response(JSON.stringify({ text }), {
        headers: { ...corsHeaders, "Content-Type": "application/json" },
      });
    }

    // ── ACTION: answer ─────────────────────────────────────────────────────────
    if (action === "answer") {
      const parts = [];
      parts.push({
        text: `You are MCKL AI Assistant for Methodist College Kuala Lumpur Penang.
Answer questions using only the provided context below.
Each context entry shows its upload date (e.g. "uploaded 13 Jun 2026"). If multiple entries cover the same topic, always prefer and use information from the most recently uploaded one, and disregard older conflicting information.
If the context does not contain relevant information, say: "I don't have that information yet – please contact the college directly."
Be concise, friendly, and professional.

Context:
${context || "No context available."}`,
      });
      if (Array.isArray(history) && history.length > 0) {
        for (const msg of history) {
          parts.push({
            text: `${msg.role === "user" ? "User" : "Assistant"}: ${msg.content}`,
          });
        }
      }
      parts.push({ text: `User: ${question}` });
      parts.push({ text: "Assistant:" });

      const res = await fetch(
        `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${geminiKey}`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            contents: [{ parts }],
            generationConfig: { maxOutputTokens: 800, temperature: 0.7 },
          }),
        }
      );
      if (!res.ok) {
        const errText = await res.text();
        throw new Error(`Gemini answer error ${res.status}: ${errText}`);
      }
      const json = await res.json();
      const answer = json?.candidates?.[0]?.content?.parts?.[0]?.text;
      if (!answer) throw new Error("No answer returned from Gemini.");
      return new Response(JSON.stringify({ answer }), {
        headers: { ...corsHeaders, "Content-Type": "application/json" },
      });
    }

    throw new Error(`Unknown action: "${action}". Expected "embed", "vision", or "answer".`);

  } catch (err) {
    console.error("Edge Function error:", err);
    return new Response(JSON.stringify({ error: err.message }), {
      status: 500,
      headers: { ...corsHeaders, "Content-Type": "application/json" },
    });
  }
});