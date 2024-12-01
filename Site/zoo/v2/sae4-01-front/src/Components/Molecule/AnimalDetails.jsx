import React, { useEffect, useState } from "react";

// eslint-disable-next-line import/named
import { useLocation, useParams } from "wouter";
import { getAnimalById } from "../Page/FetchHook";

function AnimalDetails() {
  const { animalId } = useParams();
  const [animal, setAnimal] = useState(null);
  const [parent1, setParent1] = useState(null);
  const [parent2, setParent2] = useState(null);
  const [, setLocation] = useLocation();
  useEffect(() => {
    getAnimalById(animalId).then((json) => {
      if (json.status === 404) {
        setLocation("/animals");
      }
      setAnimal(json);
    });
  }, [animalId]);

  return (
    <>
      {animal && (
        <div className="animalDetails">
          <style>
            {`
              .subsectionTitle {
                margin-top: 100px;
              }
              .animalDetails {
                color: white;
              }
            `}
          </style>
          <h1 className="subsectionTitle">
            {/* eslint-disable-next-line react/no-unescaped-entities */}
            Fiche de l'animal {animal.name} ({animal.species.name})
          </h1>
          <dl>
            <dt>Nom :</dt>
            <dd>{animal.name}</dd>

            <dt>Description :</dt>
            <dd>{animal.description}</dd>

            <dt>Espèce :</dt>
            <dd>
              <span className="badge bg-secondary">
                <a href="/" style={{ color: "white", textDecoration: "none" }}>
                  {animal.species.name}
                </a>
              </span>
            </dd>

            <dt>Enclos :</dt>
            <dd>
              <span className="badge bg-secondary">
                {animal.enclosure.name}
              </span>
            </dd>

            <dt>Image :</dt>
            <dd>
              <img
                src={`http://localhost:8000${animal.image}`}
                width="256"
                height="256"
                alt="animal"
              />
            </dd>

            {parent1 && (
              <>
                <dt>Parent(s) :</dt>
                <dd>
                  <ul>
                    <li>
                      <span className="badge bg-secondary">
                        <a href="/">{parent1}</a>
                      </span>
                    </li>
                    {parent2 && (
                      <li>
                        <span className="badge bg-secondary">
                          <a href="/">{parent2}</a>
                        </span>
                      </li>
                    )}
                  </ul>
                </dd>
              </>
            )}
          </dl>
        </div>
      )}
    </>
  );
}

export default AnimalDetails;
