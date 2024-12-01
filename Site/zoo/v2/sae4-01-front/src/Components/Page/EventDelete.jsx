import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { navigate } from "wouter/use-browser-location";
import { deleteEvent, getEventById } from "./FetchHook";
import Loading from "../Atomic/Loading";
import NotFound from "./NotFound";
import { getMe } from "../../api/zoo";

export default function EventDelete({ params }) {
  const [eventData, setEventData] = useState();
  const [isAdmin, setIsAdmin] = useState();
  useEffect(() => {
    getEventById(params.id).then((json) => {
      setEventData(json);
    });
    getMe().then((userMe) => {
      if (userMe != null) {
        setIsAdmin(userMe.roles.includes("ROLE_ADMIN"));
      }
    });
  }, []);
  const handleCancel = () => {
    navigate(`/events/${params.id}`);
  };
  const handleSubmit = async (event) => {
    event.preventDefault();
    await deleteEvent(params.id);
    navigate("/events");
  };
  if (!isAdmin) {
    return <NotFound />;
  }
  return (
    <>
      {eventData ? (
        <div className="d-flex flex-column align-items-center">
          <span className="alert alert-danger">
            Voulez-vous vraiment supprimer l'évènement {eventData.name}
          </span>
          <form
            name="event"
            method="post"
            encType="multipart/form-data"
            className="d-flex justify-content-between"
          >
            <div className="d-flex align-items-center">
              <button
                aria-label="cancel_button"
                type="submit"
                className="btn btn-secondary btn m-5"
                onClick={handleCancel}
              >
                Annuler
              </button>
              <button
                aria-label="delete_button"
                type="submit"
                className="btn btn-primary btn m-5"
                onClick={handleSubmit}
              >
                Supprimer
              </button>
            </div>
          </form>
        </div>
      ) : (
        <Loading />
      )}
    </>
  );
}

EventDelete.propTypes = {
  params: PropTypes.shape({
    id: PropTypes.string,
  }).isRequired,
};
