import React from "react";
import PropTypes from "prop-types";
import { Card, Button } from "react-bootstrap";
import { Link } from "wouter";

function Inscription({ data }) {
  return (
    <Card className="border-dark m-3" style={{ maxWidth: "18rem" }}>
      <Card.Header>Événement : {data.event.name}</Card.Header>
      <Card.Body>
        <Card.Title>
          {/* eslint-disable-next-line react/no-unescaped-entities */}
          <h5>Description de l'événement</h5>
        </Card.Title>
        <Card.Text>{data.event.description}</Card.Text>
        <Card.Title>
          {/* eslint-disable-next-line react/no-unescaped-entities */}
          <h5>Vous voulez voir votre facture ?</h5>
        </Card.Title>
        <Button variant="primary" className="w-100">
          <Link
            to={`/event/inscription/${data.id}/invoice`}
            style={{ color: "white", textDecoration: "none" }}
          >
            Voir ma facture
          </Link>
        </Button>
        <Card.Title>
          {/* eslint-disable-next-line react/no-unescaped-entities */}
          <h5>Vous devez vous désinscrire d'un événement ?</h5>
        </Card.Title>
        <Button variant="primary" className="w-100">
          <Link
            to={`/event/inscription/${data.id}/delete`}
            style={{ color: "white", textDecoration: "none" }}
          >
            Demander un remboursement
          </Link>
        </Button>
        <Card.Title className="mt-3">
          <h5>Vous souhaitez modifier votre réservation ?</h5>
        </Card.Title>
        <Button variant="success" className="w-100">
          <Link
            to={`/event/inscription/${data.id}/update`}
            style={{ color: "white", textDecoration: "none" }}
          >
            Modifier mon inscription
          </Link>
        </Button>
      </Card.Body>
    </Card>
  );
}

Inscription.propTypes = {
  data: PropTypes.shape({
    event: PropTypes.shape({
      name: PropTypes.string.isRequired,
      description: PropTypes.string.isRequired,
    }).isRequired,
    id: PropTypes.number.isRequired,
  }).isRequired,
};

export default Inscription;
