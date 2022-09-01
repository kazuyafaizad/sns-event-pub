const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: [
            "light",
            "dark",
            "cupcake",
            "bumblebee",
            "emerald",
            "corporate",
            "synthwave",
            "retro",
            "cyberpunk",
            "valentine",
            "halloween",
            "garden",
            "forest",
            "aqua",
            "lofi",
            "pastel",
            "fantasy",
            "wireframe",
            "black",
            "luxury",
            "dracula",
            "cmyk",
            "autumn",
            "business",
            "acid",
            "lemonade",
            "night",
            "coffee",
            "winter",
            // {
            //     winter: {
            //         primary: "#778bd9",

            //         accent: "#51A800",

            //         neutral: "#ab92e1",

            //         "base-100": "#f0f6f7",

            //         info: "#2463EB",

            //         success: "#16A249",

            //         warning: "#DB7706",

            //         error: "#DC2828",
            //     },
            // },
        ],
    },

    plugins: [
        require("@tailwindcss/typography"),
        require("daisyui"),
        require("postcss-100vh-fix"),
    ],
};
