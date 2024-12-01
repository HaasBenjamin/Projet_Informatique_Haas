import React, { useEffect, useState } from "react";
import { fetchAllAnimalCategory } from "./FetchHook";
import CardItem from "../Molecule/CardItem";
import Loading from "../Atomic/Loading";

function AnimalCategoryList() {
  const [categoryData, setcategoryData] = useState();
  useEffect(() => {
    fetchAllAnimalCategory().then((data) => {
      setcategoryData(data);
    });
  }, []);
  return (
    // eslint-disable-next-line react/jsx-no-useless-fragment
    <>
      <h1 className="subpageTitle text-center">
        Liste des catégories présentes au sein du zoo
      </h1>
      <hr />
      <link rel="stylesheet" href="/css/categories.css" />
      {!categoryData ? (
        <Loading />
      ) : (
        <section className="listctg">
          {categoryData?.map((category) => (
            <CardItem key={category.id} data={category} type="Category" />
          ))}
        </section>
      )}
    </>
  );
}

export default AnimalCategoryList;
