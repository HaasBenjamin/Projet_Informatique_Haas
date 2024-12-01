import React from "react";
import PropTypes from "prop-types";
import { Button, Card, CardBody, CardText } from "react-bootstrap";

export default function AnimalItem({ data = {}, userIsAdmin = false }) {
  return (
    <li>
      <Card
        style={{
          display: "flex",
          flexDirection: "row",
          width: "80vh",
          margin: "15px",
        }}
      >
        {/* eslint-disable-next-line jsx-a11y/img-redundant-alt,jsx-a11y/alt-text */}
        {data.image && (
          <img
            src={`http://localhost:8000${data.image}`}
            width={256}
            height={256}
          />
        )}
        {!data.image && <img src="/img/default.png" width={256} height={256} />}
        <CardBody style={{ width: "max-content" }}>
          <CardText>{`${data.name} (${data.species.name})`}</CardText>
          <CardText>{data.description}</CardText>
          <Button
            variant="primary"
            href={`/animals/${data.id}`}
            className="w-50"
          >
            Afficher les détails à propos de {data.name}
          </Button>
          {userIsAdmin ? (
            <div className="d-flex flex-column">
              <Button
                variant="warning"
                href={`/animals/${data.id}/update`}
                className="mt-1 w-50"
              >
                {" "}
                Modifier les détails à propos de {data.name}{" "}
              </Button>
              <Button
                variant="danger"
                href={`/animals/${data.id}/delete`}
                className="mt-1 w-50"
              >
                {" "}
                Supprimer {data.name}{" "}
              </Button>
            </div>
          ) : (
            <div />
          )}
        </CardBody>
      </Card>
    </li>
  );
}

AnimalItem.propTypes = {
  data: PropTypes.shape({
    "@id": PropTypes.string.isRequired,
    "@type": PropTypes.string.isRequired,
    name: PropTypes.string.isRequired,
    description: PropTypes.string.isRequired,
    species: PropTypes.object,
    enclosure: PropTypes.object,
  }).isRequired,
  userIsAdmin: PropTypes.bool,
};
