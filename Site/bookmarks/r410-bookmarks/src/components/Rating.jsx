// eslint-disable-next-line import/no-extraneous-dependencies
import PropTypes from "prop-types";
import React from "react";
// eslint-disable-next-line import/no-extraneous-dependencies
import { faStar, faX } from "@fortawesome/free-solid-svg-icons";
// eslint-disable-next-line import/no-extraneous-dependencies
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

function Rating({ value = 0 }) {
  const valueround = Math.round(value * 10) / 10;
  const nbPleine = Math.floor(valueround / 2);
  const etoilepleine = [];
  let ind = 0;
  for (let i = 0; i < nbPleine; i += 1) {
    etoilepleine.push(ind);
    ind += 1;
  }

  const etoilevide = [];
  for (let j = 0; j < 5 - etoilepleine.length; j += 1) {
    etoilevide.push(ind);
    ind += 1;
  }
  return (
    <span className="rating">
      <span className="center">{valueround}</span>
      <span>
        {etoilepleine.map((indice) => (
          <FontAwesomeIcon key={indice} icon={faStar} />
        ))}
        {etoilevide.map((indice) => (
          <FontAwesomeIcon key={indice} icon={faX} />
        ))}
      </span>
    </span>
  );
}

Rating.propTypes = {
  value: PropTypes.number,
};

Rating.defaultProps = {
  value: 0,
};

export default Rating;
