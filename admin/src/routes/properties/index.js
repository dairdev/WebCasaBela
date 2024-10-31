import PropertiesList from "./../../components/property/list";
import { Box, Container } from "@mui/material";

const PropertiesRoute = () => {
  return (
    <Container maxWidth="xl">
      <Box sx={{ borderBottom: 1, borderColor: "divider" }}>
        <PropertiesList />
      </Box>
    </Container>
  );
};
export default PropertiesRoute;
