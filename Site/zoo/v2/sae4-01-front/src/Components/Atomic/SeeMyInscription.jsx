import React, { useContext } from "react";
import { Link } from "wouter";
import { CurrentUserContext } from "../../Contexts/User/User";

export default function SeeMyInscription() {
  const userContext = useContext(CurrentUserContext);
  return (
    userContext && (
      <Link
        to={`user/${userContext.id}`}
        className="btn userButton btn-success"
      >
        Voir mes Inscriptions
      </Link>
    )
  );
}
