// Load this file after the Supabase CDN bundle:
// https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2

const SUPABASE_URL = "https://okijsilavgrlaeoxveuh.supabase.co";
const SUPABASE_ANON_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9raWpzaWxhdmdybGFlb3h2ZXVoIiwicm9sZSI6ImFub24iLCJpYXQiOjE3Nzg3MzI3NTMsImV4cCI6MjA5NDMwODc1M30.HO_O7N1WRo09F5FV05_c21RiXkrQ1hpikibxrG80aW0";

if (!window.supabase || typeof window.supabase.createClient !== "function") {
  throw new Error(
    "Supabase JS is not loaded. Include the CDN script before supabaseClient.js."
  );
}

window.supabaseClient = window.supabase.createClient(
  SUPABASE_URL,
  SUPABASE_ANON_KEY
);

window.supabaseConfig = {
  url: SUPABASE_URL,
  anonKey: SUPABASE_ANON_KEY,
};
