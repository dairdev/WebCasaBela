import { useState, useEffect } from 'preact/hooks';
import { TextField, Button, Card, CardContent, CardMedia, Container, CircularProgress, Typography, Box, MenuItem, Select, FormControl, InputLabel } from '@mui/material';
import Grid from '@mui/material/Grid2';
import { fetchDepartments, fetchProvinces, fetchDistricts, fetchPropertyTypes, createProperty, uploadFile } from './../../../apilocal'; // Importamos las funciones de api.js

const PropertyForm = () => {
  const [loading, setLoading] = useState(false);    // Estado de carga
  const [error, setError] = useState(null);         // Manejo de errores
  const [formData, setFormData] = useState({
    description: '',
    address: '',
    floor: '',
    number: '',
    base_price: '',
    shown_price: '',
    contract_price: '',
    covered_area: '',
    build_area: '',
    total_area: '',
    rooms: '',
    bathrooms: '',
    garages: '',
    year_build: '',
    propertytype_id: '',
    department_id: '',
    province_id: '',
    district_id: ''
  });

  const [departments, setDepartments] = useState([]);
  const [provinces, setProvinces] = useState([]);
  const [districts, setDistricts] = useState([]);
  const [types, setTypes] = useState([]);

  const [image, setImage] = useState(null);         // Imagen seleccionada
  const [images, setImages] = useState([]);         // Imagen seleccionada
  const [previewUrl, setPreviewUrl] = useState(''); // URL de la imagen cargada

  useEffect(() => {
    // Fetch all departments on component mount
    fetchDepartments()
      .then(setDepartments)
      .catch(error => console.error(error));

    // Fetch all Property types
    fetchPropertyTypes()
      .then(setTypes)
      .catch(error => console.error(error));

    //fetchImages();

  }, []);

  const handleDepartmentChange = (e) => {
    const department_id = e.target.value;
    setFormData({
      ...formData,
      department_id,
      province_id: '', // reset province when department changes
      district_id: ''  // reset district when department changes
    });

    // Fetch provinces based on selected department
    fetchProvinces(department_id)
      .then(setProvinces)
      .catch(error => console.error(error));
  };

  const handleProvinceChange = (e) => {
    const province_id = e.target.value;
    setFormData({
      ...formData,
      province_id,
      district_id: '' // reset district when province changes
    });

    // Fetch districts based on selected province
    fetchDistricts(province_id)
      .then(setDistricts)
      .catch(error => console.error(error));
  };

  const handleDistrictChange = (e) => {
    const district_id = e.target.value;
    setFormData({
      ...formData,
      district_id
    });
  };

  const handleTypeChange = (e) => {
    const propertytype_id = e.target.value;
    setFormData({
      ...formData,
      propertytype_id
    });
  };

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log(formData);
    createProperty(formData)
      .then(response => {
        console.log('Property created successfully:', response);
        // Do something on success (e.g., reset form or show success message)
      })
      .catch(error => {
        console.error('Error creating property:', error);
      });
  };

  // Función para manejar el cambio en el input file
  const handleImageChange = (e) => {
    setImage(e.target.files[0]);
    setPreviewUrl(URL.createObjectURL(e.target.files[0])); // Preview local
  };

  // Función para manejar el envío del formulario y subir la imagen
  const handleUpload = async (e) => {
    e.preventDefault();
    if (!image) {
      alert('Por favor selecciona una imagen.');
      return;
    }

    try {
      setLoading(true);
      setError(null);

      const {data, error} = await uploadFile(0,image);

      if (data) {
        // Si la subida es exitosa, obtenemos la ruta de la imagen
        console.log(data);
      } else {
        throw new Error(error || 'Error al subir la imagen.');
      }
    } catch (error) {
      setError(error);
    } finally {
      setLoading(false);
    }
  };

  // Función para recuperar todas las imágenes del bucket
  const fetchImages = async () => {
    const { data, error } = await fetchUploadedImages(1);
    console.log(data);
    if (error) {
      console.error('Error al obtener imágenes:', error.message);
    } else {
      const imageUrls = (data || []).map((item) => {
        return fetchImage(item.name);
      });
      setImages(imageUrls);
    }
  };

  return (
    <Container maxWidth="lg" spacing={2}>
      <Typography variant="h5" gutterBottom>
        Propiedad
      </Typography>
      <Grid container id='gridMain' spacing={2} >
        <Grid size={{xs:12, md:6}} id='gridForm'>
          <form onSubmit={handleSubmit}>
            <Grid container spacing={2}>
              <Grid size={{xs:12, md:6}}>
                <FormControl fullWidth variant="outlined"
                  size="small"
                >
                  <InputLabel>Tipo</InputLabel>
                  <Select
                    name="propertytype_id"
                    value={formData.propertytype_id}
                    label="Tipo"
                    onChange={handleTypeChange}
                    size="small"
                  >
                    {types.map(type => (
                      <MenuItem key={type.id} value={type.id}>
                        {type.description}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>          </Grid>
              {/* Other fields */}
              <Grid size={12}>
                <TextField
                  fullWidth
                  label="Descripción"
                  name="description"
                  value={formData.description}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={12}>
                <TextField
                  fullWidth
                  label="Dirección"
                  name="address"
                  value={formData.address}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Numero"
                  name="number"
                  value={formData.number}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Piso"
                  name="floor"
                  value={formData.floor}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Año Construcción"
                  name="year_build"
                  type="number"
                  value={formData.year_build}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                />
              </Grid>
              {/* Ubicación section */}
              <Grid size={{xs: 12, md: 4}}>
                <FormControl fullWidth variant="outlined"
                  size="small"
                >
                  <InputLabel>Departmento</InputLabel>
                  <Select
                    name="department_id"
                    value={formData.department_id}
                    onChange={handleDepartmentChange}
                    label="Departmento"
                    size="small"
                  >
                    <MenuItem value="">Departamento</MenuItem>
                    {departments.map(department => (
                      <MenuItem key={department.id} value={department.id}>
                        {department.name}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <FormControl fullWidth variant="outlined" disabled={!formData.department_id}
                  size="small"
                >
                  <InputLabel>Provincia</InputLabel>
                  <Select
                    name="province_id"
                    value={formData.province_id}
                    onChange={handleProvinceChange}
                    label="Provincia"
                    size="small"
                  >
                    {provinces.map(province => (
                      <MenuItem key={province.id} value={province.id}>
                        {province.name}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <FormControl fullWidth variant="outlined" disabled={!formData.province_id}
                  size="small"
                >
                  <InputLabel
                  >Distrito</InputLabel>
                  <Select
                    name="district_id"
                    value={formData.district_id}
                    onChange={handleDistrictChange}
                    label="Distrito"
                    size="small"
                  >
                    {districts.map(district => (
                      <MenuItem key={district.id} value={district.id}>
                        {district.name}
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Grid>

              {/* Other fields */}
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Precio Base"
                  name="base_price"
                  type="number"
                  value={formData.base_price}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Precio Publicado"
                  name="shown_price"
                  type="number"
                  value={formData.shown_price}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Precio Final"
                  name="contract_price"
                  type="number"
                  value={formData.contract_price}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Area Cubierta (m²)"
                  name="covered_area"
                  type="number"
                  value={formData.covered_area}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Area Construida (m²)"
                  name="build_area"
                  type="number"
                  value={formData.build_area}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Area Total (m²)"
                  name="total_area"
                  type="number"
                  value={formData.total_area}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Habitaciones"
                  name="rooms"
                  type="number"
                  value={formData.rooms}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Baños"
                  name="bathrooms"
                  type="number"
                  value={formData.bathrooms}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
              <Grid size={{xs: 12, md: 4}}>
                <TextField
                  fullWidth
                  label="Cocheras"
                  name="garages"
                  type="number"
                  value={formData.garages}
                  onChange={handleChange}
                  variant="outlined"
                  size="small"
                  required
                />
              </Grid>
            </Grid>
            <Box mt={3}>
              <Button variant="contained" color="primary" type="submit" 
                onClick={handleSubmit}>
                Guardar
              </Button>
            </Box>
          </form>
        </Grid>
        <Grid size={{xs:12, md:6}}>
          <Box>
            <form onSubmit={handleUpload}>
              <input
                type="file"
                accept="image/*"
                onChange={handleImageChange}
                multiple
                required
              />
              <Button variant="contained" type="submit" disabled={loading}>
                {loading ? <CircularProgress size={24} /> : 'Subir Imagen'}
              </Button>
            </form>

            {/* Mostrar la Material Card solo si hay una imagen cargada */}
            {previewUrl && (
              <Card sx={{ maxWidth: 345, marginTop: '20px' }}>
                <CardMedia
                  component="img"
                  height="140"
                  image={previewUrl}
                  alt="Imagen subida"
                />
                <CardContent>
                  <Typography gutterBottom variant="h5" component="div">
                    Imagen Subida
                  </Typography>
                  <Typography variant="body2" color="text.secondary">
                    Aquí está la imagen que acabas de cargar.
                  </Typography>
                </CardContent>
              </Card>
            )}

            {/* Mostrar error en caso de haber alguno */}
            {error && (
              <Typography color="error" variant="body1">
                {error}
              </Typography>
            )}
          </Box>
          <Box sx={{ display: 'flex', flexWrap: 'wrap', gap: 2 }}>
            {images.map((image, index) => (
              <Card key={index} sx={{ width: 200 }}>
                <CardMedia
                  component="img"
                  height="140"
                  image={image}
                />
                <CardContent>
                  <Typography variant="body2" color="text.secondary">
                    {image.name}
                  </Typography>
                </CardContent>
              </Card>
            ))}
          </Box>
        </Grid>
      </Grid>
    </Container>
  );
};

export default PropertyForm;
