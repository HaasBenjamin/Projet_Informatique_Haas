// eslint-disable-next-line import/no-extraneous-dependencies
import PropTypes from "prop-types";
import React from "react";
import { Link } from "wouter";
import Rating from "./Rating";
import { avatarUrl } from "../services/api/bookmarks";

function BookmarkItem({ data }) {
  return (
    <article className="item">
      <Rating value={data.rateAverage} />
      <Link to={`/bookmarks/${data.id}`} className="rateurl">
        <p>{data.name}</p>
      </Link>
      {/* eslint-disable-next-line react/prop-types */}
      <Link to={`/users/${data.owner.split("/").pop()}`}>
        <img src={avatarUrl(data.owner)} alt="icone" />
      </Link>
    </article>
  );
}

BookmarkItem.propTypes = {
  data: PropTypes.objectOf(
    PropTypes.shape({
      rateAverage: PropTypes.number.isRequired,
      name: PropTypes.string.isRequired,
      id: PropTypes.string.isRequired,
      owner: PropTypes.string.isRequired,
    }),
  ),
};

BookmarkItem.defaultProps = {
  data: { rating: 0, name: "Inconnu", owner: "bookmarks/users/1", url: "/" },
};

export default BookmarkItem;
