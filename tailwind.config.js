/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {
            fontFamily: {
                sans: [
                    "Poppins",
                    "Hind Siliguri",
                    "ui-sans-serif",
                    "system-ui",
                    "sans-serif",
                ],
            },
            colors: {
                primary: {
                    50: "#eef6ff",
                    100: "#d9ebff",
                    500: "#0d6efd",
                    600: "#0b5ed7",
                    700: "#0a53be",
                },
                brand: {
                    DEFAULT: "#0e4d92",
                    dark: "#09325f",
                },
            },
        },
    },
    plugins: [],
};
