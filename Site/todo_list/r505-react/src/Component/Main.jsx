import React, { useEffect } from "react";
import { Box } from "@mui/material";
import { useDispatch, useSelector } from "react-redux";
import {
  createNotification,
  isAuthenticated,
} from "../store/slices/notification";
import { useAuthMutation } from "../services/task";
import LoginForm from "./LoginForm";
import useServiceWorker from "../hooks/useServiceWorker";
import Home from "./Home";

function Main() {
  const dispatch = useDispatch();
  const onNotificationClick = (content, typeNotification) => {
    dispatch(
      createNotification({
        type: "createNotification",
        content,
        typeNotification,
      }),
    );
  };
  const isServiceWorker = useServiceWorker(
    "/sw.js",
    (information) => {
      onNotificationClick(information, "info");
    },
    () => {
      dispatch(
        isAuthenticated({
          type: "isAuthenticated",
          authenticated: true,
        }),
      );
    },
    () => {
      dispatch(
        isAuthenticated({
          type: "isAuthenticated",
          authenticated: false,
        }),
      );
    },
  );

  if (!isServiceWorker) {
    return <Box className="main-container" />;
  }

  const [auth, authResult] = useAuthMutation();
  const onSubmit = (e) => {
    e.preventDefault();
    // const login = e.target[0].value;
    // const password = e.target[1].value;
    const body = { login: "haas0008", password: "mdp_react" };
    auth(body);
  };

  useEffect(() => {
    if (!authResult.isLoading) console.log(authResult);
  }, [authResult]);

  const authenticated = useSelector(
    (state) => state.notificationReducer.authenticated,
  );
  // const { data, error, isLoading } = useGetMeQuery();

  if (authResult.isLoading) {
    return (
      <Box className="main-container">
        <div className="spinner-border mt-2 spinner" role="status">
          <span className="visually-hidden">Loading...</span>
        </div>
      </Box>
    );
  }
  return (
    <Box className="main-container">
      {!authenticated ||
      authResult.isError ||
      authResult.status === "uninitialized" ? (
        <LoginForm onSubmit={onSubmit} />
      ) : (
        <Home onNotificationClick={onNotificationClick} />
      )}
    </Box>
  );
}

export default Main;
