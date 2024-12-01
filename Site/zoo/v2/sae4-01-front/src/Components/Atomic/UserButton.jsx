import React, { useContext } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faKey } from "@fortawesome/free-solid-svg-icons";
import { loginUrl, logoutUrl } from "../../api/zoo";
import { CurrentUserContext } from "../../Contexts/User/User";

export default function UserButton() {
  const userContext = useContext(CurrentUserContext);
  // Login loading screen deleted...
  return userContext == null ? (
    <a className="btn userButton btn-success" href={loginUrl()}>
      Connexion <FontAwesomeIcon icon={faKey} />
    </a>
  ) : (
    <a className="btn userButton btn-danger" href={logoutUrl()}>
      Déconnexion <FontAwesomeIcon icon={faKey} />{" "}
    </a>
  );
}
