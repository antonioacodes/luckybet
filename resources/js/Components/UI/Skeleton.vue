<template>
    <div class="skeleton">
      <div v-if="type === 'text'" class="skeleton-text"></div>
      <div v-if="type === 'image'" class="skeleton-image"></div>
      <div v-if="type === 'card'" class="skeleton-card">
        <div class="skeleton-card-header"></div>
        <div class="skeleton-card-body">
          <div class="skeleton-text"></div>
          <div class="skeleton-text"></div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Skeleton',
    props: {
      type: {
        type: String,
        required: true
      }
    }
  }
  </script>
  
  <style scoped>
  .skeleton {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  .skeleton-text {
    height: 20px;
    width: 100%;
    background: #e0e0e0;
    border-radius: 4px;
    animation: pulse 1.5s infinite ease-in-out;
  }
  
  .skeleton-image {
    width: 100%;
    height: 200px;
    background: #e0e0e0;
    border-radius: 4px;
    animation: pulse 1.5s infinite ease-in-out;
  }
  
  .skeleton-card {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  .skeleton-card-header {
    height: 100px;
    background: #e0e0e0;
    border-radius: 4px;
    animation: pulse 1.5s infinite ease-in-out;
  }
  
  .skeleton-card-body {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  @keyframes pulse {
    0% {
      background-color: #e0e0e0;
    }
    50% {
      background-color: #f5f5f5;
    }
    100% {
      background-color: #e0e0e0;
    }
  }
  </style>