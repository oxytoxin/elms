const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php"
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    500: "#28A745",
                    600: "#1E5631"
                },
                secondary: {
                    500: "#2C384A"
                }
            },
            spacing: {
                "72": "18rem",
                "84": "21rem",
                "96": "24rem"
            },
            minHeight: {
                "1": "0.25rem",
                "2": "0.5rem",
                "3": "0.75rem",
                "4": "1rem",
                "5": "1.25rem",
                "6": "1.5rem",
                "8": "2rem",
                "10": "2.5rem",
                "12": "3rem",
                "16": "4rem",
                "20": "5rem",
                "24": "6rem",
                "32": "8rem",
                "40": "10rem",
                "48": "12rem",
                "56": "14rem",
                "64": "16rem",
                "72": "18rem",
                "84": "21rem",
                "96": "24rem",
                halfscreen: "50vh"
            },
            minWidth: {
                "1": "0.25rem",
                "2": "0.5rem",
                "3": "0.75rem",
                "4": "1rem",
                "5": "1.25rem",
                "6": "1.5rem",
                "8": "2rem",
                "10": "2.5rem",
                "12": "3rem",
                "16": "4rem",
                "20": "5rem",
                "24": "6rem",
                "32": "8rem",
                "40": "10rem",
                "48": "12rem",
                "56": "14rem",
                "64": "16rem",
                "72": "18rem",
                "84": "21rem",
                "96": "24rem",
                halfscreen: "50vw"
            },
            maxHeight: {
                "1": "0.25rem",
                "2": "0.5rem",
                "3": "0.75rem",
                "4": "1rem",
                "5": "1.25rem",
                "6": "1.5rem",
                "8": "2rem",
                "10": "2.5rem",
                "12": "3rem",
                "16": "4rem",
                "20": "5rem",
                "24": "6rem",
                "32": "8rem",
                "40": "10rem",
                "48": "12rem",
                "56": "14rem",
                "64": "16rem",
                "72": "18rem",
                "84": "21rem",
                "96": "24rem",
                halfscreen: "50vh"
            },
            maxWidth: {
                "1": "0.25rem",
                "2": "0.5rem",
                "3": "0.75rem",
                "4": "1rem",
                "5": "1.25rem",
                "6": "1.5rem",
                "8": "2rem",
                "10": "2.5rem",
                "12": "3rem",
                "16": "4rem",
                "20": "5rem",
                "24": "6rem",
                "32": "8rem",
                "40": "10rem",
                "48": "12rem",
                "56": "14rem",
                "64": "16rem",
                "72": "18rem",
                "84": "21rem",
                "96": "24rem",
                halfscreen: "50vw"
            },
            fontFamily: {
                sans: ["Montserrat", ...defaultTheme.fontFamily.sans]
            }
        }
    },

    variants: {
        opacity: ["responsive", "hover", "focus", "disabled"]
    },

    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true
    },
    plugins: [require("@tailwindcss/ui")]
};
