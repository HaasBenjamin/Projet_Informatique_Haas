import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faHourglass } from "@fortawesome/free-solid-svg-icons";

function Loading() {
  return (
    <div className="loading">
      <span>Loading</span> <FontAwesomeIcon icon={faHourglass} />
    </div>
  );
}

export default Loading;
