import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { deleteInscription, fetchRegistration } from "./FetchHook.js";
import Loading from "../Atomic/Loading.jsx";
import dayjs from "dayjs";

function InscriptionRefund({ params }) {
  const [inscription, setInscription] = useState();
  useEffect(() => {
    fetchRegistration(params.id).then((response) => {
      setInscription(response);
    });
  }, []);
  console.log(inscription);
  return (
    <>
      {inscription ? (
        <>
          <link rel="stylesheet" href="/css/invoice.css" />
          <h1 className="subpageTitle text-center">
            Récapitulatif de votre commande
          </h1>
          <ul className="invoice">
            <li>Événement :</li>
            <ul>
              <li>Nom de l'événement : {inscription.event.name}</li>
              <li>Description : {inscription.event.description}</li>
              <li>Durée de l'événement : {inscription.event.duration} minutes</li>
            </ul>
            <li>Inscription :</li>
            <ul>
              <li>Date de l'événement : {dayjs(inscription?.date).format('DD-MM-YYYY')}</li>
              <li>Nombre de places réservées : {inscription.nbReservedPlaces} places</li>
            </ul>
            <li>Informations utilisateurs :</li>
            <ul>
              <li>Nom : {inscription.user.lastname}</li>
              <li>Prénom : {inscription.user.firstname}</li>
              <li>Email : {inscription.user.email}</li>
              <li>Date de naissance :  {dayjs(inscription.user.dateOfBirth).format('DD-MM-YYYY')}</li>
            </ul>
            <li>Prix de l'inscription : 3.99€</li>
          </ul>
          <h1 className="subpageTitle text-center">Merci de votre visite !</h1>
        </>
      ) : (
        <Loading />
      )}
    </>
  );
}

InscriptionRefund.propTypes = {
  params: PropTypes.shape({
    id: PropTypes.string,
  }).isRequired,
};

export default InscriptionRefund;
