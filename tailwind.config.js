const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

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
                sans: ["proxima-nova", ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            transparent: "transparent",
            current: "currentColor",
            black: colors.black,
            white: colors.white,
            green: colors.green,
            gray: colors.gray,
            slate: colors.slate,
            green: colors.green,
            blue: colors.blue,
            orange: colors.orange,
            red: colors.red,
            indigo: colors.indigo,
            yellow: colors.yellow,
            // mainone: "#34a4b5",
            mainone: "#2bb7cc",
            mainone_light: "#40c9da",
            mainone_medium: "#35cfd4",
            blueone: "#499bef",
            darkone: "#293547",
            darkone_dark: "#374350",
            darkone_light: "#374345",
            grayone: "#ebebeb",
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
