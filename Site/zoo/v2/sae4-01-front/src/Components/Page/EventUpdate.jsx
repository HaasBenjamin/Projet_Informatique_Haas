import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { navigate } from "wouter/use-browser-location";
import {
  fetchAllEnclosures,
  fetchAllEventDate,
  getEventById,
  patchEvent,
} from "./FetchHook";
import Loading from "../Atomic/Loading";
import { getMe } from "../../api/zoo";
import NotFound from "./NotFound";

export default function EventUpdate({ params }) {
  const [eventData, setEventData] = useState();
  const [eventDateData, setEventDateData] = useState();
  const [enclosuresData, setEnclosuresData] = useState();
  const [isAdmin, setIsAdmin] = useState();
  useEffect(() => {
    getEventById(params.id).then((json) => {
      setEventData(json);
    });
    fetchAllEnclosures().then((json) => {
      setEnclosuresData(json["hydra:member"]);
    });
    fetchAllEventDate().then((json) => {
      setEventDateData(json["hydra:member"]);
    });
    getMe().then((userMe) => {
      if (userMe != null) {
        setIsAdmin(userMe.roles.includes("ROLE_ADMIN"));
      }
    });
  }, []);
  const handleSubmit = async (event) => {
    event.preventDefault();
    const data = {
      id: params.id,
      name: event.target[0].value,
      description: event.target[1].value,
      duration: parseInt(event.target[3].value, 10),
      quota: parseInt(event.target[2].value, 10),
      enclosure: `/api/enclosures/${event.target[4].value}`,
      eventDates: Array.from(event.target[5].selectedOptions).map(
        (option) => `/api/event_dates/${option.value}`,
      ),
    };
    await patchEvent(data);
    navigate(`/events/${params.id}`);
  };
  if (!isAdmin) {
    return <NotFound />;
  }
  return (
    <>
      {eventData && eventDateData && enclosuresData ? (
        <form
          name="event"
          method="post"
          encType="multipart/form-data"
          onSubmit={handleSubmit}
          className="m-5"
        >
          <div className="mb-3">
            <label
              htmlFor="event_name"
              className="form-label required"
              aria-label="event_name"
            >
              Nom de l&#039;évènement
            </label>
            <input
              type="text"
              id="event_name"
              name="event[name]"
              required="required"
              maxLength="128"
              className="form-control"
              defaultValue={eventData.name}
            />
          </div>
          <div className="mb-3">
            <label htmlFor="event_quota" className="form-label required">
              Description de l&#039;évènement
            </label>
            <input
              type="text"
              id="event_description"
              name="event[description]"
              required="required"
              maxLength="512"
              className="form-control"
              defaultValue={eventData.description}
            />
          </div>
          <div className="mb-3 text-white">
            <label htmlFor="event_description" className="form-label required">
              Quota de l&#039;évènement
            </label>
            <input
              type="number"
              id="event_quota"
              name="event[quota]"
              required="required"
              min="0"
              max="300"
              className="form-control"
              defaultValue={eventData.quota}
            />
          </div>
          <div className="mb-3 text-white">
            <label htmlFor="event_duration" className="form-label required">
              Durée de l&#039;évènement
            </label>
            <input
              type="number"
              id="event_duration"
              name="event[duration]"
              required="required"
              min="0"
              max="300"
              className="form-control"
              defaultValue={eventData.duration}
            />
          </div>
          <div>
            <label htmlFor="event_enclosure" className="form-label required">
              Enclos de l&#039;évènement
            </label>
            <select
              id="event_enclosure"
              name="event[enclosure]"
              required="required"
              className="form-select"
              defaultValue={eventData.enclosure.id}
            >
              <option value=""> Enclos ?</option>
              {enclosuresData.map((enclosure) => (
                <option value={enclosure.id} key={enclosure.id}>
                  {enclosure.name}
                </option>
              ))}
            </select>
          </div>
          <div>
            <label htmlFor="event_dates" className="form-label required">
              Dates de l&#039;évènement
            </label>
            <select
              id="event_dates"
              name="event[eventDates]"
              required="required"
              className="form-select"
              defaultValue={null}
              multiple
            >
              <option value=""> Dates ?</option>
              {eventDateData.map((eventDate) => (
                <option value={eventDate.id} key={eventDate.id}>
                  {eventDate.date}
                </option>
              ))}
            </select>
          </div>
          <button
            aria-label="submit_button"
            type="submit"
            className="w-100 d-inline-block btn btn-primary"
          >
            Modifier
          </button>
        </form>
      ) : (
        <Loading />
      )}
    </>
  );
}

EventUpdate.propTypes = {
  params: PropTypes.shape({
    id: PropTypes.string,
  }).isRequired,
};
