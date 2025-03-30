import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { Link } from "wouter";
import Loading from "../components/Loading";
import NotFound from "./NotFound";
// eslint-disable-next-line import/named
import { getUserBookmarks, getUserDetail } from "../services/api/bookmarks";
import UserDetails from "../components/UserDetails";
import BookmarksList from "../components/BookmarksList";
import Pagination from "../components/Pagination";
import PaginationFromHydraView from "../services/transformers/paginationFromHydraView";

function UserDetail({ id }) {
  const [userDetails, setUserDetails] = useState(null);
  const [bookmarkList, setBookmarkList] = useState(null);
  const [pagination, setPagination] = useState();
  const [page, setPage] = useState(1);
  useEffect(() => {
    getUserDetail(parseInt(id, 10))
      .then((response) => {
        response.json().then((json) => {
          if (json.status === 404) {
            setUserDetails(undefined);
          } else {
            setUserDetails(json);
          }
        });
      })
      .catch(() => {
        setUserDetails(undefined);
      });
  }, []);
  useEffect(() => {
    if (userDetails) {
      getUserBookmarks(
        new URLSearchParams(`page=${page}&owner=/users/${userDetails.id}`),
      )
        .then((response) => {
          response.json().then((json) => {
            if (json.status === 404) {
              setBookmarkList(undefined);
            } else {
              setBookmarkList(json["hydra:member"]);
              setPagination(PaginationFromHydraView(response["hydra:view"]));
            }
          });
        })
        .catch(() => {
          setBookmarkList(undefined);
        });
    }
  }, [userDetails, page]);
  if (userDetails === null) {
    return <Loading />;
  }
  if (!userDetails) {
    return <NotFound description="Ressource non trouvée" />;
  }
  return (
    <>
      <UserDetails
        data={{
          userFirstName: userDetails.firstname,
          userLastName: userDetails.lastname,
          userLogin: userDetails.login,
          userAvatar: `/bookmarks/users/${id}`,
        }}
      />
      <article className="bookList">
        Liste des bookmarks de cet utilisateur :
        {bookmarkList && <BookmarksList bookmarksData={bookmarkList} />}
        {pagination && (
          <Pagination
            pagination={pagination}
            onClick={(pageid) => {
              setPage(pageid);
            }}
          />
        )}
      </article>
      {/* eslint-disable-next-line react/no-unescaped-entities */}
      <Link to="/">Page d'accueil</Link>
    </>
  );
}

UserDetail.propTypes = {
  id: PropTypes.string,
};

UserDetail.defaultProps = {
  id: { id: 1 },
};
export default UserDetail;
