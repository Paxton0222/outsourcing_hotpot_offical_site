import defaultTheme from "tailwindcss/defaultTheme"
import daisyui from "daisyui"
import { config } from "dotenv"

import typography from "@tailwindcss/typography"

config()

const darkTheme = import.meta.env.VITE_DARK_THEME ?? "dark"

/** @type {import("tailwindcss").Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [typography, daisyui],

    // daisyUI config (optional - here are the default values)
    daisyui: {
        themes: true, // false: only light + dark | true: all themes | array: specific themes like this ["light", "dark", "cupcake"]
        darkTheme: darkTheme, // name of one of the included themes for dark mode
        base: true, // applies background color and foreground color for root element by default
        styled: true, // include daisyUI colors and design decisions for all components
        utils: true, // adds responsive and modifier utility classes
        prefix: "", // prefix for daisyUI classnames (components, modifiers and responsive class names. Not colors)
        logs: true, // Shows info about daisyUI version and used config in the console when building your CSS
        themeRoot: ":root", // The element that receives theme color CSS variables
    },

    darkMode: ["class", `[data-theme="${darkTheme}"]`],

    extends: {
        animation: {
            fadeIn: "fadeIn 0.5s ease-out forwards",
            fadeOut: "fadeOut 0.5s ease-in forwards",
        },
        keyframes: {
            fadeIn: {
                "0%": { opacity: 0 },
                "100%": { opacity: 1 },
            },
            fadeOut: {
                "0%": { opacity: 1 },
                "100%": { opacity: 0 },
            },
        },
    },
}
