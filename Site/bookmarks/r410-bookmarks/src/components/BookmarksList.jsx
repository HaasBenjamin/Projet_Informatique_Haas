import React from "react";
import PropTypes from "prop-types";
import BookmarkItem from "./BookmarkItem";

function BookmarksList({ bookmarksData }) {
  return (
    <section>
      {bookmarksData.map((book) => (
        <BookmarkItem key={book.id} data={book} />
      ))}
    </section>
  );
}

BookmarksList.propTypes = {
  bookmarksData: PropTypes.arrayOf(
    PropTypes.shape({
      rateAverage: PropTypes.number.isRequired,
      name: PropTypes.string.isRequired,
      id: PropTypes.number.isRequired,
      owner: PropTypes.string.isRequired,
    }),
  ),
};

BookmarksList.defaultProps = {
  bookmarksData: {},
};
export default BookmarksList;
