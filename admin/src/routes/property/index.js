import { useState } from "preact/hooks";
import { Box, Container } from '@mui/material';
import PropertyForm from "./../../components/property/form";
import PropertiesList from "./../../components/property/list";
import { Fragment } from "preact";

const PropertyRoute = () => {

  return (
    <Container maxWidth="xl">
      <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
          <PropertyForm onSubmit={handlePropertySubmit} propertyToEdit={propertyToEdit} />
      </Box>
    </Container>
  );
};

export default PropertyRoute;
