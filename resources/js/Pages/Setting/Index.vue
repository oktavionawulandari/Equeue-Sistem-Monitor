<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-6">
          <h1 class="m-0">Setting</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <Link href="/dashboard">Home</Link>
            </li>
            <li class="breadcrumb-item active">Setting</li>
          </ol>
        </div>
      </div>

      <div v-if="Object.keys(form.errors).length > 0" class="alert alert-danger alert-dismissible show fade" role="alert">
        <strong>Error!</strong> 
        <ul>
          <li v-if="errors.instansi">{{ errors.instansi }}</li>
          <li v-if="errors.address">{{ errors.address }}</li>
          <li v-if="errors.phone">{{ errors.phone }}</li>
          <li v-if="errors.email">{{ errors.email }}</li>
          <li v-if="errors.running_text">{{ errors.running_text }}</li>
          <li v-if="errors.video">{{ errors.video }}</li>
          <li v-if="errors.logo">{{ errors.logo }}</li>
          <li v-if="errors.background">{{ errors.background }}</li>
          <li v-if="errors.text_color">{{ errors.text_color }}</li>
          <li v-if="errors.primary">{{ errors.primary }}</li>
          <li v-if="errors.accent">{{ errors.accent }}</li>
          <li v-if="errors.secondary">{{ errors.secondary }}</li>
        </ul>
        <button class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      
      <div class="row">
        <div class="col-9">
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="submitForm">
                <div class="form-group">
                  <label for="instansi">Nama Instansi</label>
                  <input 
                      type="text" 
                      class="form-control" 
                      v-model="form.instansi"
                      :class="{'is-invalid': errors.instansi}"
                      id="instansi"
                      name="instansi"
                      />
                  <div v-if="errors.instansi" class="invalid-feedback">
                    {{ errors.instansi }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="address">Alamat Instansi</label>
                  <input 
                      type="text" 
                      class="form-control" 
                      v-model="form.address"
                      :class="{'is-invalid': errors.address}"
                      id="address"
                      name="address"
                      />
                  <div v-if="errors.address" class="invalid-feedback">
                    {{ errors.address }}
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Telepon</label>
                      <input 
                          type="text" 
                          class="form-control" 
                          v-model="form.phone"
                          :class="{'is-invalid': errors.phone}"
                          id="phone"
                          name="phone"
                        />
                      <div v-if="errors.phone" class="invalid-feedback">
                        {{ errors.phone }}
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input 
                          type="email" 
                          class="form-control" 
                          v-model="form.email"
                          :class="{'is-invalid': errors.email}"
                          id="email"
                          name="email"
                        />
                      <div v-if="errors.email" class="invalid-feedback">{{ errors.email }}</div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="running_text">Running Text</label>
                  <input 
                      type="text" 
                      class="form-control" 
                      v-model="form.running_text"
                      :class="{'is-invalid': errors.running_text}"
                      id="running_text"
                      name="running_text"
                      />
                  <div v-if="errors.running_text" class="invalid-feedback">
                    {{ errors.running_text }}</div>
                </div>

                <div class="form-group">
                  <label for="video">Video URL</label>
                  <input
                      type="text"
                      class="form-control"
                      v-model="form.video"
                      :class="{'is-invalid': errors.video}"
                      id="video"
                      name="video"/>
                  <div v-if="errors.video" class="invalid-feedback">
                    {{ errors.video }}</div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-5">
                  <div class="col-auto">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Logo Upload -->
        <div class="col-3">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label for="logo">Logo</label>
                <img v-if="logoPreview" :src="logoPreview" alt="Logo Preview" style="max-width: 200px; margin-bottom: 10px;" />
                <input type="file" class="form-control" id="logo" accept="image/*" @change="previewImage" />
                <div v-if="form.errors.logo" class="invalid-feedback">{{ form.errors.logo }}</div>
              </div>

              <div class="row">
                <div class="col-6" v-for="(colorField, index) in colorFields" :key="index">
                  <div class="form-group">
                    <label :for="colorField.name">{{ colorField.label }}</label>
                    <input type="color" class="form-control" :id="colorField.name" v-model="form[colorField.name]" />
                    <div v-if="form.errors[colorField.name]" class="invalid-feedback">{{ form.errors[colorField.name] }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, Link, router } from '@inertiajs/vue3';

const form = useForm({
  instansi: '',
  address: '',
  phone: '',
  email: '',
  running_text: '',
  video: '',
  logo: null,
  background: '',
  text: '',
  primary: '',
  accent: '',
  secondary: '',
});

const logoPreview = ref(null);

const colorFields = [
  { name: 'background', label: 'Background' },
  { name: 'text', label: 'Teks' },
  { name: 'accent', label: 'Random' },
  { name: 'primary', label: 'Navigasi' },
  { name: 'secondary', label: 'Footer' },
];

function previewImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      logoPreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
    form.logo = file; 
  }
}
const errors = ref({});

function submitForm() {
    form.post('/setting', {
        onSuccess: () => {
            router.visit('/setting');
        },
        onError: (formErrors) => {
            errors.value = formErrors;
        }
    });
}
</script>

<script>
import Dashboard from '../../Layout/Dasboard.vue';

export default {
  layout: Dashboard,
};
</script>
