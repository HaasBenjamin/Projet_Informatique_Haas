import React, { useContext, useEffect, useState } from "react";
import { useLocation } from "wouter";
import PropTypes from "prop-types";
import dayjs from "dayjs";
import { fetchRegistration, patchInscription } from "./FetchHook";
import InscriptionForm from "../Molecule/InscriptionForm";
import { CurrentUserContext } from "../../Contexts/User/User";

export default function InscriptionUpdate({ inscriptionId }) {
  const [inscription, setInscription] = useState();
  const user = useContext(CurrentUserContext);
  const [, setLocation] = useLocation();

  useEffect(() => {
    fetchRegistration(inscriptionId).then((reponse) => setInscription(reponse));
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();
    const form = e.target;
    const today = dayjs().format("YYYY-MM-DD");
    if (dayjs(e.target[0].value).isBefore(today, "day")) {
      alert("La date ne peut pas être antérieure à aujourd'hui !");
      return;
    }
    patchInscription(
      inscriptionId,
      JSON.stringify({ date: form[0].value, nbReservedPlaces: form[1].value }),
    )
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

  return (
    <>
      <h1 style={{ color: "white" }}>Modification d'une inscription</h1>
      {inscription && (
        <h1 style={{ color: "white" }}>Evenement : {inscription.event.name}</h1>
      )}
      {user && (
        <h1 style={{ color: "white" }}> Utilisateur : {user.firstname}</h1>
      )}
      {inscription && (
        <InscriptionForm
          method="PATCH"
          submit="Modifier Inscription"
          onSubmit={handleSubmit}
          inscription={inscription}
        />
      )}
    </>
  );
}

InscriptionUpdate.propType = {
  inscriptionId: PropTypes.number.isRequired,
};
