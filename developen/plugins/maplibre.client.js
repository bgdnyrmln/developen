import { defineNuxtPlugin } from "#app";
import "maplibre-gl/dist/maplibre-gl.css";

export default defineNuxtPlugin(() => {
  // No need to register anything globally, since we'll use MapLibre directly in components
});
