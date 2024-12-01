import React, { useContext } from "react";
// eslint-disable-next-line import/no-unresolved
import { Link } from "wouter";
import PropTypes from "prop-types";
import UserButton from "../Atomic/UserButton.jsx";

export default function Header({ title = "Title" }) {
    return (
        <header className="app__header header">
            <Link href="/">
                <h1 className="header__title">
                    {title}
                </h1>
            </Link>
            <UserButton />
        </header>
    );
}

Header.propTypes = {
    title: PropTypes.string,
};
