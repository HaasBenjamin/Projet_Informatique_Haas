import React from "react";
import PropTypes from "prop-types";
import Section from "../contexts/user/Provider";
// eslint-disable-next-line import/named
import { getRandomColor } from "../contexts/title/index";

export default function Footer({ setColor }) {
  return (
    <>
      <Section level={1} />
      <button
        type="button"
        onClick={() => {
          setColor(getRandomColor());
        }}
      >
        {" "}
        Générer une nouvelle couleur{" "}
      </button>
    </>
  );
}

Footer.propTypes = {
  setColor: PropTypes.func.isRequired,
};
