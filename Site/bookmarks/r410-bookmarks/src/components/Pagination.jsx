// eslint-disable-next-line import/no-extraneous-dependencies
import PropTypes from "prop-types";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faBackwardFast,
  faBackwardStep,
  faForwardFast,
  faForwardStep,
} from "@fortawesome/free-solid-svg-icons";
import React from "react";

export default function Pagination({ pagination = {}, onClick }) {
  return (
    <div className="pagination">
      <button
        aria-label="first"
        type="button"
        onClick={() => {
          onClick(pagination.first);
        }}
      >
        <FontAwesomeIcon icon={faBackwardFast} />
      </button>
      <button
        aria-label="previous"
        type="button"
        disabled={!pagination.previous}
        onClick={() => {
          onClick(pagination.previous);
        }}
      >
        <FontAwesomeIcon icon={faBackwardStep} />
      </button>
      <span>{pagination.current}</span>
      <button
        aria-label="next"
        type="button"
        disabled={!pagination.next}
        onClick={() => {
          onClick(pagination.next);
        }}
      >
        <FontAwesomeIcon icon={faForwardStep} />
      </button>
      <button
        aria-label="last"
        type="button"
        onClick={() => {
          onClick(pagination.last);
        }}
      >
        <FontAwesomeIcon icon={faForwardFast} />
      </button>
    </div>
  );
}

Pagination.propTypes = {
  pagination: PropTypes.shape({
    current: PropTypes.number.isRequired,
    first: PropTypes.number.isRequired,
    previous: PropTypes.number,
    id: PropTypes.string,
    next: PropTypes.number,
    last: PropTypes.number.isRequired,
  }),
  onClick: PropTypes.func,
};

Pagination.defaultProps = {
  pagination: {
    current: 2,
    first: 1,
    previous: 1,
    id: 1,
    next: 3,
    last: 3,
  },
  onClick: () => {},
};
