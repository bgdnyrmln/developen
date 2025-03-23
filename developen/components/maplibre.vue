<template>
    <div>
      <div ref="mapContainer" class="map-container"></div>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref } from "vue";
  import maplibregl from "maplibre-gl";
  
  const mapContainer = ref(null);
  
  onMounted(() => {
    if (mapContainer.value) {
      new maplibregl.Map({
        container: mapContainer.value,
        style: "https://api.maptiler.com/maps/0195b883-fb89-7ad1-8019-cf73e6274e74/style.json?key=wlY4b87x1EJ4jqvvsihV", // Public MapLibre style
        center: [ 24.114870, 56.951288], // Longitude, Latitude
        zoom: 15,
      });
    }
  });
  </script>
  
  <style>
  .map-container {
    width: 100%;
    height: 50vh;
  }
  </style>
  