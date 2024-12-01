import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { deleteInscription, fetchRegistration } from "./FetchHook.js";
import Loading from "../Atomic/Loading.jsx";

function InscriptionRefund({ params }) {
  const [inscription, setInscription] = useState();
  useEffect(() => {
    fetchRegistration(params.id).then((response) => {
      setInscription(response);
      deleteInscription(inscription.id);
    });
  }, []);
  return (
    <>
      {inscription ? (
        <>
          <h1 className="mainTitle">
            Remboursement pour l'évènement {inscription.event.name} de{" "}
            {inscription.user.firstname} {inscription.user.lastname}
          </h1>
          <p className="text-white">
            Déçu de voir que vous ne pourriez pas assister à l'évènement, un
            remboursement sera fait dans les plus brefs délais. En espérant vous
            revoir.
          </p>
          <table className="table text-white">
            <thead>
              <tr>
                <th scope="col">Nom Évènement</th>
                <th scope="col">Date Évènement</th>
                <th scope="col">Nombre de place de réservés</th>
                <th scope="col">Prix unitaire</th>
                <th scope="col">Montant</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{inscription.event.name}</td>
                <td>{inscription.date}</td>
                <td>{inscription.nbReservedPlaces}</td>
                <td>3.99</td>
                <td className="table-warning">{inscription.nbReservedPlaces * 3.99}</td>
              </tr>
            </tbody>
          </table>
          <div className="d-flex flex-column text-white">
            <h2 className="align-self-start">Besoin d'aides ?</h2>
            <p>
              Si vous avez des difficultés avec le remboursement ou si vous
              souhaitez obtenir plus d'informations, n'hésitez pas à nous
              contacter par e-mail à service.client@zootechparl.com ou par
              téléphone au 03 26 91 30 02. Notre équipe de support client est là
              pour vous aider et se fera un plaisir de répondre à vos questions.
            </p>
          </div>
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
