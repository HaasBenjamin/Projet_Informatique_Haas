import { Box, Button } from "@mui/material";
import Icon from "@mui/material/Icon";
import React, { useState } from "react";
import PropTypes from "prop-types";
import { taskApi, useGetTaskListsQuery } from "../services/task";

function Home({ onNotificationClick }) {
  const { refetch } = taskApi.endpoints.getTaskLists.useQuerySubscription(
    null,
    {
      refetchOnMountOrArgChange: true,
      skip: false,
    },
  );
  const { data } = useGetTaskListsQuery();
  const [nbTasks, setNbTasks] = useState(
    data && data["hydra:totalItems"] ? data["hydra:totalItems"] : 0,
  );
  const refetchTasks = () => {
    refetch().then((rep) => {
      if (rep.isError) {
        onNotificationClick("Utilisateur déconnecté", "error");
      } else {
        setNbTasks(rep["hydra:totalItems"]);
      }
    });
  };
  return (
    <Box>
      <Box className="main-container">
        <Button onClick={() => onNotificationClick("Erreur", "error")}>
          <Box className="action">
            <Icon>error</Icon>
            <Box>Error</Box>
          </Box>
        </Button>
        <Button onClick={() => onNotificationClick("Attention", "warning")}>
          <Box className="action">
            <Icon>warning</Icon>
            <Box>Warning</Box>
          </Box>
        </Button>
        <Button onClick={() => onNotificationClick("Information", "info")}>
          <Box className="action">
            <Icon>info</Icon>
            <Box>Info</Box>
          </Box>
        </Button>
        <Button onClick={() => onNotificationClick("Succès", "success")}>
          <Box className="action">
            <Icon>done</Icon>
            <Box>Success</Box>
          </Box>
        </Button>
      </Box>
      <Box style={{ textAlign: "center" }}>Nombre de tâches : {nbTasks}</Box>
      <Button onClick={refetchTasks} style={{ width: "100%" }}>
        Relancer la recherche des tâches
      </Button>
    </Box>
  );
}

Home.propTypes = {
  onNotificationClick: PropTypes.func.isRequired,
};

export default Home;
