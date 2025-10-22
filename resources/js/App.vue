<template>
  <div id="app" class="container">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App'
};
</script>

<style> /* Use <style> without 'scoped' for global styles if needed */
body {
  font-family: sans-serif;
  margin: 0;
  background-color: #f4f4f4;
  color: #333;
}

.container {
  max-width: 600px;
  margin: 40px auto; /* Center the container */
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  text-align: center;
}

h1 {
  color: #42b983; /* Vue green */
  margin-bottom: 20px;
}

/* Basic form styling */
form {
  display: flex;
  flex-direction: column;
  align-items: stretch; /* Make form elements take full width */
  gap: 15px; /* Add space between form elements */
  margin-bottom: 20px;
  text-align: left;
}

form div {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
}

button {
  padding: 12px 15px;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #36a374;
}

/* Link styling */
a {
  color: #42b983;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

p {
  margin-top: 15px;
}

nav {
    margin-top: 20px;
}
</style>