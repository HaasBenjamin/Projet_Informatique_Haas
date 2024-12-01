import React, { useEffect, useState } from "react";
import { fetchAllFamilies } from "./FetchHook";
import CardItem from "../Molecule/CardItem";
import Loading from "../Atomic/Loading";

export default function Families() {
  const [familiesData, setFamiliesData] = useState([]);
  useEffect(() => {
    fetchAllFamilies(new URLSearchParams()).then((json) => {
      setFamiliesData(json["hydra:member"]);
    });
  }, []);
  return (
    <>
      <h1 className="subpageTitle text-center">Liste des familles </h1>
      <hr />
      {!familiesData ? (
        <Loading />
      ) : (
        <ul
          className="container d-flex flex-wrap justify-content-center"
          style={{ listStyle: "none" }}
        >
          {familiesData.map((family) => (
            <CardItem key={family.id} data={family} type="Family" />
          ))}
        </ul>
      )}
    </>
  );
}
