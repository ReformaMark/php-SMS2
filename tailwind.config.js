/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [ 
    "./public/**/*.php",
    "./src/**/*.php",
    "./**/*.php", // This will ensure all PHP files are included
    "./index.php",
  ],
   theme: {
     extend: {
      height: {
        'custom': 'calc(100vh - 5rem)', // Add your custom utility
      },
      
     },
},
   plugins: [],
}   