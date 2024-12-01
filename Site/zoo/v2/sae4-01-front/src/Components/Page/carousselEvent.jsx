import React, { useEffect, useState } from "react";
import { Carousel, CarouselItem } from "react-bootstrap";
import { fetchAllEvents } from "./FetchHook";
import EventItem from "../Molecule/EventItem";
import { getMe } from "../../api/zoo";

function CarousselEvent() {
  const [eventData, setEventData] = useState();
  const [userIsAdmin, setUserIsAdmin] = useState();
  useEffect(() => {
    setEventData(null);
    fetchAllEvents().then((data) => setEventData(data));
    getMe().then((userMe) => {
      if (userMe != null) {
        setUserIsAdmin(userMe.roles.includes("ROLE_ADMIN"));
      }
    });
  }, []);

  const [index, setIndex] = useState(2);

  const handleSelect = (selectedIndex) => {
    setIndex(selectedIndex);
  };
  return (
    <>
      <link rel="stylesheet" href="/css/events.css" />
      <h1 className="subpageTitle text-center">Liste des évènements </h1>
      <Carousel
        className="w-100 align-items-center justify-content-center"
        activeIndex={index}
        onSelect={handleSelect}
      >
        {eventData?.map((event) => (
          <CarouselItem key={event.id} className="w-100">
            <EventItem key={event.id} data={event} userIsAdmin={userIsAdmin} />
          </CarouselItem>
        ))}
      </Carousel>
    </>
  );
}

export default CarousselEvent;
