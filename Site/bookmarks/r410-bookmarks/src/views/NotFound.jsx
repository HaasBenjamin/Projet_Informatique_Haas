import React from "react";
// eslint-disable-next-line import/no-extraneous-dependencies
import { Link } from "wouter";
import PropTypes from "prop-types";

function NotFound({ description = "erreur de routage" }) {
  return (
    <>
      <div>Erreur lors du chargement de la page : {description} </div>
      {/* eslint-disable-next-line react/no-unescaped-entities */}
      <Link href="/">Page d'accueil</Link>
    </>
  );
}

NotFound.propTypes = {
  description: PropTypes.string,
};

NotFound.defaultProps = {
  description: "erreur de routage",
};

export default NotFound;
