import plugin from "tailwindcss/plugin";

export const userState = plugin(function ({ addVariant }) {
    addVariant("user-free", [
        `[data-user-state="Free"] &`,
        `[data-user-state="free"] &`,
    ]);
    addVariant("user-premium", [
        `[data-user-state="Premium"] &`,
        `[data-user-state="premium"] &`,
    ]);
});
