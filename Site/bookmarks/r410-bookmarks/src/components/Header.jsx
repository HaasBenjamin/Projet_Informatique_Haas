import React from "react";
import PropTypes from "prop-types";
import UserButton from "./UserButton";

export default function Header({ title, color }) {
  return (
    <section className="title_connexion">
      <h1 style={{ color }}>{title}</h1>
      <UserButton />
    </section>
  );
}

Header.propTypes = {
  title: PropTypes.string,
  color: PropTypes.string,
};

Header.defaultProps = {
  title: "Liste des bookmarks",
  color: "white",
};
