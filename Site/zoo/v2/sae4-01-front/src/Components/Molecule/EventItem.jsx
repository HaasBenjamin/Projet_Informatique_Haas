import React from "react";
import PropTypes from "prop-types";
import { Button } from "react-bootstrap";

function EventItem({ data = {}, userIsAdmin = false }) {
  return (
    <div className="event">
      <span className="badge bg-warning">
        <a
          href={`/events/${data.id}`}
          className="text-white text-decoration-none"
        >
          {data.name}
        </a>
      </span>
      <span className="badge bg-secondary"> {data.enclosure.name} </span>
      {userIsAdmin ? (
        <div>
          <Button
            variant="danger"
            href={`/events/${data.id}/delete`}
            className="w-100"
          >
            {" "}
            Supprimer{" "}
          </Button>
          <Button
            variant="success"
            href={`/events/${data.id}/update`}
            className="w-100"
          >
            {" "}
            Modifier{" "}
          </Button>
        </div>
      ) : (
        <div />
      )}
    </div>

  );
}

EventItem.propTypes = {
  data: PropTypes.shape({
    name: PropTypes.string,
    enclosure: PropTypes.shape({
      id: PropTypes.number,
      name: PropTypes.string,
    }),
  }).isRequired,
  userIsAdmin: PropTypes.bool,
};

export default EventItem;
