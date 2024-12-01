import React from "react";
import dayjs from "dayjs";

export default function InscriptionForm({
  method = "post",
  title = "",
  submit,
  onSubmit,
  inscription = {},
}) {
  const today = Date.now();
  console.log(dayjs(inscription?.date).format("YYYY-MM-DD"));
  return (
    <form
      name={title}
      method={method}
      onSubmit={onSubmit}
      encType="multipart/form-data"
    >
      <div className="mb-3">
        <label htmlFor="inscriptions_date" style={{ color: "white" }} className="form-label">Choisir une date :</label>
        <input name="date" type="date" min={today} defaultValue={dayjs(inscription?.date).format('YYYY-MM-DD')}  required className="form-control"/>
      </div>
      <div className="mb-3">
        <label htmlFor="inscription_number" style={{ color: "white" }}>
          Nombre de places
        </label>
        <input
          name="nbReservedPlaces"
          type="number"
          min="1"
          defaultValue={inscription?.nbReservedPlaces}
          required
          className="form-control"
        />
      </div>

      <button type="submit" className="w-100 d-inline-block btn btn-success">
        {submit}
      </button>
    </form>
  );
}
