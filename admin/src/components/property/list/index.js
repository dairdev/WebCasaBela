import { useState, useEffect } from "preact/hooks";
import {
  TextField,
  Button,
  Card,
CardContent,
  Container,
  Typography,
  Box,
  MenuItem,
  Select,
  FormControl,
  InputLabel,
} from "@mui/material";
import Grid from "@mui/material/Grid2";
import {
  fetchDepartments,
  fetchProvinces,
  fetchDistricts,
  fetchPropertyTypes,
  fetchProperties,
} from "./../../../apilocal";

const PropertiesList = ({ onEdit }) => {
  const [properties, setProperties] = useState([]);
  const [filters, setFilters] = useState({
    propertytype_id: '',
    department_id: '',
    province_id: '',
    district_id: ''
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
      <Grid container spacing={2}>
        <Grid size={{ xs: 12, md: 3 }}>
          <FormControl fullWidth variant="outlined" size="small">
            <InputLabel>Tipo</InputLabel>
            <Select
              name="propertytype_id"
              value={filters.propertytype_id}
              label="Tipo"
              onChange={handleTypeChange}
              size="small"
            >
              {types.map((type) => (
                <MenuItem key={type.id} value={type.id}>
                  {type.description}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </Grid>
        {/* Ubicación section */}
        <Grid size={{ xs: 12, md: 3 }}>
          <FormControl fullWidth variant="outlined" size="small">
            <InputLabel>Departmento</InputLabel>
            <Select
              name="department_id"
              value={filters.department_id}
              onChange={handleDepartmentChange}
              label="Departmento"
              size="small"
            >
              {departments.map((department) => (
                <MenuItem key={department.id} value={department.id}>
                  {department.name}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </Grid>
        <Grid size={{ xs: 12, sm: 3 }}>
          <FormControl
            fullWidth
            variant="outlined"
            disabled={!filters.department_id}
            size="small"
          >
            <InputLabel>Provincia</InputLabel>
            <Select
              name="province_id"
              value={filters.province_id}
              onChange={handleProvinceChange}
              label="Provincia"
              size="small"
            >
              {provinces.map((province) => (
                <MenuItem key={province.id} value={province.id}>
                  {province.name}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </Grid>
        <Grid size={{ xs: 12, sm: 3 }}>
          <FormControl
            fullWidth
            variant="outlined"
            disabled={!filters.province_id}
            size="small"
          >
            <InputLabel>Distrito</InputLabel>
            <Select
              name="district_id"
              value={filters.district_id}
              onChange={handleDistrictChange}
              label="Distrito"
              size="small"
            >
              {districts.map((district) => (
                <MenuItem key={district.id} value={district.id}>
                  {district.name}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </Grid>
      </Grid>
      <Grid container spacing={2}>
        { ( !properties || properties.length === 0 ) ? 
          <Box>No hay propiedades registradas</Box>
          : properties.map( (property) => 
            (
              <Grid key={property.id} size={{xs: 12, sm: 4}}>
            <Card>
                  <CardContent>
                    <Typography gutterBottom sx={{ color: 'text.secondary', fontSize: 14 }}>
                      { property.description }
                    </Typography>
                    <Typography variant="h5" component="div">
                      { property.address }
                    </Typography>
                  </CardContent>
            </Card>
              </Grid>
            )
          ) 
        }
      </Grid>
    </Container>
  );
};

export default PropertiesList;
