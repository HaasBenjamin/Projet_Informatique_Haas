import {createContext, useState} from "react";
import {themeLight} from "../../assets/themes/ListTheme.jsx";


export const themeContext = createContext({
    theme: themeLight,
    themeStatus: 'light',
    switchTheme: () => {}
});