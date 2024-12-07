import { useState, useEffect } from "preact/hooks";
import {
  Box,
  TextField,
  Button,
  Container,
  Card,
  CardContent,
  Grid,
  Typography,
  MenuItem,
  Drawer,
  IconButton,
  Select,
  CardMedia,
  Divider,
  Fab,
  useMediaQuery,
} from "@mui/material";
import Grid2 from "@mui/material/Grid2";
import {
  Add,
  BedroomParent,
  Bathtub,
  DirectionsCar,
  SquareFoot,
  Menu as MenuIcon,
} from "@mui/icons-material";
import { styled } from "@mui/material/styles";

import {
  fetchDepartments,
  fetchProvinces,
  fetchDistricts,
  fetchPropertyTypes,
  fetchProperties,
} from "./../../../apilocal";
import { route } from "preact-router";

const fabStyle = {
  position: 'absolute',
  bottom: 16,
  right: 16,
};

// Estilos para la columna izquierda (filtros)
const SidebarContainer = styled(Box)(({ theme }) => ({
  width: "25%",
  [theme.breakpoints.down("md")]: {
    display: "none",
  },
}));

// Layout responsive para el drawer en pantallas móviles
const MobileSidebarContainer = styled(Drawer)(({ theme }) => ({
  display: "none",
  [theme.breakpoints.down("md")]: {
    display: "block",
  },
}));

// Contenedor de la grilla de propiedades
const GridContainer = styled(Grid)(({ theme }) => ({
  flexGrow: 1,
  [theme.breakpoints.down("md")]: {
    paddingLeft: theme.spacing(0),
  },
}));

const PropertiesList = () => {
  const [drawerOpen, setDrawerOpen] = useState(false);
  const isMobile = useMediaQuery((theme) => theme.breakpoints.down("md"));

  const [properties, setProperties] = useState([
    {
      id: 1,
      title: "Casa de 2 pisos en venta",
      address: "Av. Principal 123, Distrito X",
      type: "Casa",
      build_area: "120m²",
      rooms: 3,
      bathrooms: 2,
      garages: 1,
    },
  ]);

  const [searchTerm, setSearchTerm] = useState("");
  const [sortOrder, setSortOrder] = useState("");
  const [filters, setFilters] = useState({
    propertytype_id: "",
    department_id: "",
    province_id: "",
    district_id: "",
  });
  const [departments, setDepartments] = useState([]);
  const [provinces, setProvinces] = useState([]);
  const [districts, setDistricts] = useState([]);
  const [types, setTypes] = useState([]);

  useEffect(() => {
    fetchProperties()
      .then(setProperties)
      .catch((error) => console.error(error));

    // Fetch all departments on component mount
    fetchDepartments()
      .then(setDepartments)
      .catch((error) => console.error(error));

    // Fetch all Property types
    fetchPropertyTypes()
      .then(setTypes)
      .catch((error) => console.error(error));
  }, []);

  const toggleDrawer = () => {
    setDrawerOpen(!drawerOpen);
  };

  const handleSearchChange = (event) => {
    setSearchTerm(event.target.value);
  };

  const handleSortChange = (event) => {
    setSortOrder(event.target.value);
  };

  const filteredProperties = properties
    .filter(
      (property) =>
        property.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
        property.address.toLowerCase().includes(searchTerm.toLowerCase()),
    )
    .sort((a, b) => {
      if (sortOrder === "priceAsc") return a.shown_price - b.shown_price;
      if (sortOrder === "priceDesc") return b.shown_price - a.shown_price;
      if (sortOrder === "areaDesc") return b.build_area - a.build_area;
      return 0;
    });

  const handleDepartmentChange = (e) => {
    const department_id = e.target.value;
    setFilters({
      ...filters,
      department_id,
      province_id: "", // reset province when department changes
      district_id: "", // reset district when department changes
    });

    // Fetch provinces based on selected department
    fetchProvinces(department_id)
      .then(setProvinces)
      .catch((error) => console.error(error));
  };

  const handleProvinceChange = (e) => {
    const province_id = e.target.value;
    setFilters({
      ...filters,
      province_id,
      district_id: "", // reset district when province changes
    });

    // Fetch districts based on selected province
    fetchDistricts(province_id)
      .then(setDistricts)
      .catch((error) => console.error(error));
  };

  const handleDistrictChange = (e) => {
    const district_id = e.target.value;
    setFilters({
      ...filters,
      district_id,
    });
  };

  const handleTypeChange = (e) => {
    const propertytype_id = e.target.value;
    setFilters({
      ...filters,
      propertytype_id,
    });
  };

  const onDelete = async (id) => {
    /*
    const { data, error } = await supabase.from('properties').delete().eq('id', id);
    if (error) {
      console.error('Error deleting property:', error);
    } else {
      console.log('Property deleted successfully:', data);
      // Refrescar la lista de propiedades
      setProperties(properties.filter((property) => property.id !== id));
    }
    */
  };

  return (
    <Container maxWidth="xl">
      <Typography variant="h5" gutterBottom>
        Propiedades
      </Typography>
      <Box display="flex" minHeight="100vh">
        {/* Columna de Filtros */}
        <SidebarContainer>
          <Filters
            departments={departments}
            provinces={provinces}
            districts={districts}
            selectedDepartment={filters.department_id}
            setSelectedDepartment={handleDepartmentChange}
            selectedProvince={filters.province_id}
            setSelectedProvince={handleProvinceChange}
            selectedDistrict={filters.district_id}
            setSelectedDistrict={handleDistrictChange}
          />
        </SidebarContainer>

        {/* Drawer para la versión móvil */}
        <MobileSidebarContainer
          anchor="left"
          open={drawerOpen}
          onClose={toggleDrawer}
        >
          <Filters
            departments={departments}
            provinces={provinces}
            districts={districts}
            selectedDepartment={filters.department_id}
            setSelectedDepartment={handleDepartmentChange}
            selectedProvince={filters.province_id}
            setSelectedProvince={handleProvinceChange}
            selectedDistrict={filters.district_id}
            setSelectedDistrict={handleDistrictChange}
          />
        </MobileSidebarContainer>

        {/* Botón para abrir el menú de filtros en móvil */}
        {isMobile && (
          <IconButton
            onClick={toggleDrawer}
            sx={{ position: "absolute", top: 16, left: 16 }}
          >
            <MenuIcon />
          </IconButton>
        )}

        <Box flex={1} p={2}>
          <Box
            display="flex"
            alignItems="center"
            justifyContent="space-between"
            mb={2}
            gap={2}
          >
            <Select
              value={sortOrder}
              onChange={handleSortChange}
              displayEmpty
              autoWidth
            >
              <MenuItem value="">Ordenar por</MenuItem>
              <MenuItem value="priceAsc">Precio: Bajo a Alto</MenuItem>
              <MenuItem value="priceDesc">Precio: Alto a Bajo</MenuItem>
              <MenuItem value="areaDesc">Área: Mayor a Menor</MenuItem>
            </Select>
            <TextField
              placeholder="Buscar propiedades..."
              variant="outlined"
              value={searchTerm}
              onChange={handleSearchChange}
            />
          </Box>

          <Grid2 container spacing={2}>
            {filteredProperties.map((property) => (
              <Grid2 xs={12} md={4} key={property.id}>
                <Card>
                  <CardMedia
                    component="img"
                    alt="Property Image"
                    height="140"
                    image="https://via.placeholder.com/150"
                  />
                  <CardContent>
                    <Typography variant="h6">{property.title}</Typography>
                    <Typography variant="body2">{property.address}</Typography>
                    <Typography variant="subtitle2" color="textSecondary">
                      {property.type}
                    </Typography>
                    <Box display="flex" alignItems="center" mt={1} gap={1}>
                      <BedroomParent />{" "}
                      <Typography>{property.rooms}</Typography>
                      <Bathtub /> <Typography>{property.bathrooms}</Typography>
                      <DirectionsCar />{" "}
                      <Typography>{property.garages}</Typography>
                      <SquareFoot />{" "}
                      <Typography>{property.build_area}</Typography>
                    </Box>
                  </CardContent>
                </Card>
              </Grid2>
            ))}
          </Grid2>
        </Box>
          <Fab href="/property/" color="primary" sx={{ ...fabStyle, }}>
            <Add />
          </Fab>
      </Box>
    </Container>
  );
};

function Filters({
  departments,
  provinces,
  districts,
  selectedDepartment,
  setSelectedDepartment,
  selectedProvince,
  setSelectedProvince,
  selectedDistrict,
  setSelectedDistrict,
}) {
  return (
    <Box p={2} sx={{ width: 250 }} justifyContent="stretch">
      <Typography variant="h6">Filtros de Búsqueda</Typography>
      <Divider sx={{ my: 2 }} />
      <Select
        fullWidth
        value={selectedDepartment}
        onChange={(e) => setSelectedDepartment(e)}
        displayEmpty
      >
        <MenuItem value="">Selecciona Departamento</MenuItem>
        {departments.map((dept) => (
          <MenuItem key={dept.id} value={dept.id}>
            {dept.name}
          </MenuItem>
        ))}
      </Select>
      <Select
        fullWidth
        value={selectedProvince}
        onChange={(e) => setSelectedProvince(e)}
        displayEmpty
        disabled={!selectedDepartment}
        sx={{ mt: 2 }}
      >
        <MenuItem value="">Selecciona Provincia</MenuItem>
        {provinces.map((prov) => (
          <MenuItem key={prov.id} value={prov.id}>
            {prov.name}
          </MenuItem>
        ))}
      </Select>
      <Select
        fullWidth
        value={selectedDistrict}
        onChange={(e) => setSelectedDistrict(e)}
        displayEmpty
        disabled={!selectedProvince}
        sx={{ mt: 2 }}
      >
        <MenuItem value="">Selecciona Distrito</MenuItem>
        {districts.map((dist) => (
          <MenuItem key={dist.id} value={dist.id}>
            {dist.name}
          </MenuItem>
        ))}
      </Select>'
      <TextField fullWidth label="Habitaciones" variant="outlined" margin="dense" />
      <TextField fullWidth label="Baños" variant="outlined" margin="dense" />
      <TextField fullWidth label="Cocheras" variant="outlined" margin="dense" />
      <TextField fullWidth label="Área en m²" variant="outlined" margin="dense" />
      <TextField fullWidth label="Rango de Precios" variant="outlined" margin="dense" />
      <TextField fullWidth label="Antigüedad (años)" variant="outlined" margin="dense" />

      <Button variant="contained" color="primary" fullWidth sx={{ mt: 2 }}>
        Aplicar Filtros
      </Button>
    </Box>
  );
}

export default PropertiesList;
