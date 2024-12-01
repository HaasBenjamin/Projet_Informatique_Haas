import React from "react";
import { Route, Switch } from "wouter";
import NotFound from "../Components/Page/NotFound";
import Index from "../Components/Page/Index";
import Families from "../Components/Page/Families";
import Animals from "../Components/Page/Animals";
import EnclosureAnimals from "../Components/Page/EnclosureAnimals";
import UserDetail from "../Components/Page/UserDetail";
import CarousselEvent from "../Components/Page/carousselEvent";
import Species from "../Components/Page/Species";
import AboutUs from "../Components/Page/AboutUs";
import AnimalCategoryList from "../Components/Page/AnimalCategoryList";
import AnimalUpdate from "../Components/Page/AnimalUpdate";
import AnimalDelete from "../Components/Page/AnimalDelete";
import SpeciesFamily from "../Components/Page/SpeciesFamily";
import CategoryFamilies from "../Components/Page/CategoryFamilies";
import AnimalDetails from "../Components/Molecule/AnimalDetails.jsx";
import EventUpdate from "../Components/Page/EventUpdate.jsx";
import EventDelete from "../Components/Page/EventDelete.jsx";
import AnimalsSpecies from "../Components/Page/AnimalsSpecies.jsx";
import EventDescription from "../Components/Molecule/EventDescription.jsx";
import InscriptionCreate from "../Components/Page/InscriptionCreate";
import InscriptionUpdate from "../Components/Page/InscriptionUpdate";
import InscriptionDelete from "../Components/Page/InscriptionDelete";
import InscriptionRefund from "../Components/Page/InscriptionRefund.jsx";
import InscriptionInvoice from "../Components/Page/InscriptionInvoice.jsx";

export default function ZooRouter() {
  return (
    <Switch>
      <Route path="/" exact component={Index} />
      <Route path="/user/:id" exact component={UserDetail} />
      <Route path="/events" exact component={CarousselEvent} />
      <Route path="events/:id/update" exact component={EventUpdate} />
      <Route path="events/:id/delete" exact component={EventDelete} />
      <Route path="/events/:id" exact component={EventDescription} />
      <Route path="/families" exact component={Families} />
      <Route path="/families/:id" exact>
        {(params) => <CategoryFamilies params={{ id: params.id }} />}
      </Route>
      <Route path="/animals" exact component={Animals} />
      <Route path="/species" exact component={Species} />
      <Route path="/species/:id" exact>
        {(params) => <SpeciesFamily params={{ id: params.id }} />}
      </Route>
      <Route path="/species/:id/animals" exact component={AnimalsSpecies} />
      <Route path="/about_us" exact component={AboutUs} />
      <Route path="/categories" exact component={AnimalCategoryList} />
      <Route path="/animals/:animalId" exact component={AnimalDetails} />
      <Route
        path="/enclosure/:enclosureId/animals"
        component={EnclosureAnimals}
      />
      <Route path="/event/:eventId/inscription/create" exact>
        {(params) => <InscriptionCreate eventId={params.eventId} />}
      </Route>
      <Route path="/event/inscription/:inscriptionId/update" exact>
        {(params) => <InscriptionUpdate inscriptionId={params.inscriptionId} />}
      </Route>
      <Route path="/event/inscription/:inscriptionId/delete" exact>
        {(params) => <InscriptionDelete inscriptionId={params.inscriptionId} />}
      </Route>
        <Route path="/event/inscription/:id/refund" exact component={InscriptionRefund} />
        <Route path="/event/inscription/:id/invoice" exact component={InscriptionInvoice} />
      <Route path="/animals/:animalId/update" exact>
        {(params) => <AnimalUpdate animalId={params.animalId} />}
      </Route>
      <Route path="/animals/:animalId/delete" exact>
        {(params) => <AnimalDelete animalId={params.animalId} />}
      </Route>
      <Route path="/animals/:search">
        {(params) => <Animals search={params.search} />}
      </Route>

      <Route path="*" component={NotFound} />
      <Route>Routage Error</Route>
    </Switch>
  );
}
