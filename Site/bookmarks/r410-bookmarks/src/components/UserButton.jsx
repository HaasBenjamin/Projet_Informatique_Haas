import { useContext, React, useState, useEffect } from "react";
import { faKey, faSpinner } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import LevelContext from "../contexts/user/index";
import { avatarUrl, loginUrl, logoutUrl } from "../services/api/bookmarks";

export default function UserButton() {
  const level = useContext(LevelContext);
  const [owner, setOwner] = useState();
  useEffect(() => {
    level.then((response) => {
      if (response) {
        setOwner(response.id);
      } else {
        setOwner(null);
      }
    });
  }, []);
  if (owner === null) {
    return (
      <a href={loginUrl()} aria-label="Connexion">
        <FontAwesomeIcon icon={faKey} />
      </a>
    );
  }
  if (!owner) {
    return <FontAwesomeIcon icon={faSpinner} />;
  }
  return (
    <section>
      <a href={logoutUrl()}>
        <img src={avatarUrl(`/bookmarks/users/${owner}`)} alt="icone" />
      </a>
    </section>
  );
}
