import React, {useContext, useEffect, useState} from "react";
import { Link, useLocation } from "wouter";
import dayjs from "dayjs";
import { deleteInscription, fetchRegistration } from "./FetchHook";
import Loading from "../Atomic/Loading.jsx";
import PropTypes from "prop-types";
import { CurrentUserContext } from "../../Contexts/User/User";
import data from "bootstrap/js/src/dom/data.js";

export default function InscriptionDelete({ inscriptionId }) {
  const [inscription, setInscription] = useState();
  const [location, setLocation] = useLocation();
  const user = useContext(CurrentUserContext);
  useEffect(() => {
    fetchRegistration(inscriptionId).then((response) => {
      setInscription(response);
    });
  }, []);
  console.log(user);
  const handleCancel = (ev) => {
    ev.preventDefault();
    setLocation(`/user/${user.id}`);
  };

  const handleSumbmit = (ev) => {
    ev.preventDefault();
    const today = dayjs().format("YYYY-MM-DD");
    if (dayjs(inscription.date).isBefore(today, "day")) {
      alert("La date ne peut pas être antérieure à aujourd'hui !");
      return;
    }
    setLocation(`/event/inscription/${inscriptionId}/refund`);
  };
  return (
    <>
      {inscription ? (
        <>
          <h1 style={{ color: "white" }}>Evenement :{inscription.event.name}</h1>
          <h1 style={{ color: "white" }}>
            Date : {dayjs(inscription.date).format("YYYY-MM-DD")}
          </h1>
          <div className="alert alert-danger w-100 m-5" role="alert">
            {/* eslint-disable-next-line react/no-unescaped-entities */}
            Voulez-vous vraiment supprimer cette inscription ?
          </div>
          <form
            name="form"
            method="post"
            className=" d-flex m-5 justify-content-around"
          >
            <div className="mb-3">
              <button
                type="submit"
                id="form_cancel"
                name="form[cancel]"
                className="btn btn-secondary btn"
                onClick={handleCancel}
              >
                Annuler
              </button>
            </div>
            <div className="mb-3">
              <button
                type="submit"
                id="form_delete"
                name="form[delete]"
                className="btn btn-primary btn"
                onClick={handleSumbmit}
              >
                Supprimer
              </button>
            </div>
          </form>
        </>
      ) : (
        <Loading />
      )}
    </>
  );
}

InscriptionDelete.propType = {
  inscriptionId: PropTypes.number.isRequired,
};
