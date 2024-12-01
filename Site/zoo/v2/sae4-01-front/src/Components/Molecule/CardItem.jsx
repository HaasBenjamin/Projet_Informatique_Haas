import React from "react";
import PropTypes from "prop-types";
import { Card, CardBody, CardText, Button } from "react-bootstrap";

export default function CardItem({ data = {}, type = "Category" }) {
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
        {/* eslint-disable-next-line jsx-a11y/img-redundant-alt */}
        {data.image && (
          <img
            src={`http://localhost:8000${data.image}`}
            width={256}
            height={256}
            alt="Image manquante"
          />
        )}
        {!data.image && (
          <img
            src="/img/default.png"
            width={256}
            height={256}
            alt="Image manquante"
          />
        )}
        <CardBody style={{ width: "max-content" }}>
          <CardText>
            {type === "Family" ? "La famille " : "La catégorie "}
            {`des ${data.name}`}
          </CardText>
          <CardText>{data.description}</CardText>
          <Button
            variant="primary"
            href={
              type === "Category"
                ? `/families/${data.id}`
                : `/species/${data.id}`
            }
          >
            {type === "Family"
              ? "Voir les espèces appartenant à cette famille"
              : "Voir les familles appartenant à cette catégorie"}
          </Button>
        </CardBody>
      </Card>
    </li>
  );
}

CardItem.propTypes = {
  data: PropTypes.shape({
    "@id": PropTypes.string.isRequired,
    "@type": PropTypes.string.isRequired,
    // eslint-disable-next-line react/forbid-prop-types
    category: PropTypes.object,
    description: PropTypes.string.isRequired,
    id: PropTypes.number.isRequired,
    name: PropTypes.string.isRequired,
    // eslint-disable-next-line react/forbid-prop-types
    species: PropTypes.array,
    image: PropTypes.string,
  }),
  type: PropTypes.string,
};
