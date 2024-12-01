import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import Button from "react-bootstrap/Button";
import { fetchRegistrationsCollection, getEventById } from "../Page/FetchHook";
import Loading from "../Atomic/Loading.jsx";
import NotFound from "../Page/NotFound.jsx";

function EventDescription({ params }) {
  const [isRegistered, setIsRegistered] = useState(false);
  const [eventData, setEventData] = useState();
  useEffect(() => {
    setEventData(null);
    getEventById(params.id).then((json) => setEventData(json));
    fetchRegistrationsCollection().then((registrations) => {
      setIsRegistered(false);
      registrations["hydra:member"].map((registration) => {
        if (registration.event === `/api/events/${params.id}`) {
          setIsRegistered(true);
        }
      });
    });
  }, [params.id]);
  const colorWhite = {
    color: "white",
  };
  if (eventData === null) {
    return <Loading />;
  }
  if (!eventData) {
    return <NotFound />;
  }
  return (
    <>
      <h1 style={colorWhite}>{eventData.name}</h1>
      <dl style={colorWhite} className="mb-4">
        <dt> Description évènement</dt>
        <dd> {eventData.description}</dd>
        <dt> Nombre de visiteurs</dt>
        <dd> {eventData.quota}</dd>
      </dl>
      <p style={colorWhite}>Pour en apprendre plus sur d'autres évènements</p>
      {isRegistered ? (
        <>
          <Button
            style={{
              backgroundColor: "white",
              color: "grey",
              border: "1px solid grey",
            }}
            href="/"
            className="d-grid mt-2 mb-2"
          >
            {/* eslint-disable-next-line react/no-unescaped-entities */}
            Modifier votre inscription à l'évènement {eventData.name}
          </Button>
          <Button variant="danger" href="/" className="d-grid">
            {/* eslint-disable-next-line react/no-unescaped-entities */}
            Supprimer votre inscription à l'évènement {eventData.name}
          </Button>
        </>
      ) : (
        <Button variant="outline-light" href={`/event/${params.id}/inscription/create`} className="d-grid">
          {/* eslint-disable-next-line react/no-unescaped-entities */}
          S'inscrire à l'évènement {eventData.name}
        </Button>
      )}
    </>
  );
}

EventDescription.propTypes = {
  params: PropTypes.shape({
    id: PropTypes.string,
  }).isRequired,
};
export default EventDescription;
