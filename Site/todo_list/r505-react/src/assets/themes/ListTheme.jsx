import {createTheme} from "@mui/material";

export const themeLight = createTheme({
    palette: {
        mode: 'light',
        primary: {
            main: '#00f4bb',
        },
        secondary: {
            main: '#00f536',
        },
        background: {
            default: '#f14916',
        },
    },
});

export const themeDark = createTheme({
    palette: {
        mode: 'dark',
        primary: {
            main: '#0eda0e',
        },
        secondary: {
            main: '#0e100e',
        },
        background: {
            default: '#2b3c90',
        },
    },
})
