import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
import logical from "tailwindcss-logical";
import { userState } from "./resources/js/Plugins/user-state-tw";

/** @type {import('tailwindcss').Config} */
export default {
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
                sans: ["Roboto", ...defaultTheme.fontFamily.sans],
                tajawl: ["Tajawal", "sans-serif"],
                tahoma: "Tahoma, Verdana, Segoe, sans-serif;",
            },
            colors: {
                primary: "rgb(0, 100, 0)",
                primaryDark: "rgb(9, 70, 9)",
                golden: "#D1C37A",
                gold: "#FF9900",
            },
        },
        screens: {
            xs: "475px",
            ...defaultTheme.screens,
        },
    },
    plugins: [forms, typography, logical, userState],
};
