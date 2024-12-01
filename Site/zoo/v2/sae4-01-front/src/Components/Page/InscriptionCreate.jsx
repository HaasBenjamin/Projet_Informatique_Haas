import React, { useContext, useEffect, useState } from "react";
import PropTypes from "prop-types";
import { useLocation } from "wouter";
import dayjs from "dayjs";
import { fetchEvent, postInscriptions } from "./FetchHook";
import InscriptionForm from "../Molecule/InscriptionForm";
import Loading from "../Atomic/Loading";
import { CurrentUserContext } from "../../Contexts/User/User";

export default function InscriptionCreate({ eventId }) {
  const [event, setEvent] = useState();
  const user = useContext(CurrentUserContext);
  const [, setLocation] = useLocation();

  useEffect(() => {
    fetchEvent(eventId).then((json) => setEvent(json));
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();
    const today = dayjs().format("YYYY-MM-DD");
    const form = e.target;
    const formData = new FormData(form);
    if (dayjs(e.target[0].value).isBefore(today, "day")) {
      alert("La date ne peut pas être antérieure à aujourd'hui !");
      return;
    }
    formData.append("event", eventId);
    formData.append("user", user.id);
    postInscriptions(formData)
      .then((detail) => {
        if (detail.status === 200) {
          return detail.json();
        }
        setLocation(`/user/${user.id}`);
      })
      .then((errormsg) => {
        console.log(errormsg);
        if (errormsg) {
          alert(errormsg);
        }
      });
  };
  /*
  if (dayjs(selectedDate).isBefore(today, 'day')) {
      alert("La date ne peut pas être antérieure à aujourd'hui !");
      return; // Empêcher la soumission du formulaire si la date est invalide
    }
   */

  return (
    <>
      {event && user ? (
        <>
          <h1 style={{ color: "white" }}>Ajout d'une nouvelle inscription</h1>
          <h1 style={{ color: "white" }}>Evènement: {event.name}</h1>
          <h1 style={{ color: "white" }}>Utilisateur: {user.firstname}</h1>
          <InscriptionForm submit="S'inscrire" onSubmit={handleSubmit} />
        </>
      ) : (
        <Loading />
      )}
    </>
  );
}

InscriptionCreate.proptype = {
  eventId: PropTypes.number.isRequired,
};
