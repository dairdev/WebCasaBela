import { useState } from "preact/hooks";
import { Box, Container, Tab, Tabs  } from '@mui/material';
import PropertyForm from "./../../components/property/form";
import PropertiesList from "./../../components/property/list";
import { Fragment } from "preact";

const TabPanel = (props) => {
  const { children, value, index } = props;

  return (
    <Fragment>
      { value === index && <Box sx={{ p: 3 }}>{children}</Box>}
    </Fragment>
  );
}

const PropertyRoute = () => {
  const [reload, setReload] = useState(false);
  const [propertyToEdit, setPropertyToEdit] = useState(null);
  const [tabIndex, setTabIndex] = useState(0);

  const handleChangeTab = (event, newValue) => {
    setTabIndex(newValue);
  };

  const handlePropertySubmit = () => {
    setReload(!reload); // Para volver a cargar la lista de propiedades
  };

  const handleEditProperty = (property) => {
    setPropertyToEdit(property);
  };

 const a11yProps = (index) => {
  return {
    id: `simple-tab-${index}`,
    'aria-controls': `simple-tabpanel-${index}`,
  };
}


  return (
    <Container maxWidth="xl">
      <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
        <Tabs value={tabIndex} onChange={handleChangeTab} aria-label="basic tabs example">
          <Tab label="Propiedades" {...a11yProps(0)} />
          <Tab label="Datos de Propiedad" {...a11yProps(1)} />
        </Tabs>
        <TabPanel value={tabIndex} index={0}>
          <PropertiesList key={reload} onEdit={handleEditProperty} />
        </TabPanel>
        <TabPanel value={tabIndex} index={1}>
          <PropertyForm onSubmit={handlePropertySubmit} propertyToEdit={propertyToEdit} />
        </TabPanel>
      </Box>
    </Container>
  );
};

export default PropertyRoute;
