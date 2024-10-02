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
          <li v-if="form.errors.instansi">{{ form.errors.instansi }}</li>
          <li v-if="form.errors.address">{{ form.errors.address }}</li>
          <li v-if="form.errors.phone">{{ form.errors.phone }}</li>
          <li v-if="form.errors.email">{{ form.errors.email }}</li>
          <li v-if="form.errors.running_text">{{ form.errors.running_text }}</li>
          <li v-if="form.errors.video">{{ form.errors.video }}</li>
          <li v-if="form.errors.logo">{{ form.errors.logo }}</li>
          <li v-if="form.errors.background">{{ form.errors.background }}</li>
          <li v-if="form.errors.text">{{ form.errors.text }}</li>
          <li v-if="form.errors.primary">{{ form.errors.primary }}</li>
          <li v-if="form.errors.accent">{{ form.errors.accent }}</li>
          <li v-if="form.errors.secondary">{{ form.errors.secondary }}</li>
        </ul>
        <button class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      
      <div class="row">
        <div class="col-9">
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="submit">
                <div class="form-group">
                  <label for="instansi">Nama Instansi</label>
                  <input 
                      type="text" 
                      class="form-control" 
                      v-model="form.instansi"
                      :class="{'is-invalid': form.errors.instansi}"
                      id="instansi"
                      name="instansi"
                      />
                  <div v-if="form.errors.instansi" class="invalid-feedback">
                    {{ form.errors.instansi }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="address">Alamat Instansi</label>
                  <input 
                      type="text" 
                      class="form-control" 
                      v-model="form.address"
                      :class="{'is-invalid': form.errors.address}"
                      id="address"
                      name="address"
                      />
                  <div v-if="form.errors.address" class="invalid-feedback">
                    {{ form.errors.address }}
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
                          :class="{'is-invalid': form.errors.phone}"
                          id="phone"
                          name="phone"
                        />
                      <div v-if="form.errors.phone" class="invalid-feedback">
                        {{ form.errors.phone }}
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
                          :class="{'is-invalid': form.errors.email}"
                          id="email"
                          name="email"
                        />
                      <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="running_text">Running Text</label>
                  <input 
                      type="text" 
                      class="form-control" 
                      v-model="form.running_text"
                      :class="{'is-invalid': form.errors.running_text}"
                      id="running_text"
                      name="running_text"
                      />
                  <div v-if="form.errors.running_text" class="invalid-feedback">
                    {{ form.errors.running_text }}</div>
                </div>

                <div class="form-group">
                  <label for="video">Video URL</label>
                  <input
                      type="text"
                      class="form-control"
                      v-model="form.video"
                      :class="{'is-invalid': form.errors.video}"
                      id="video"
                      name="video"/>
                  <div v-if="form.errors.video" class="invalid-feedback">
                    {{ form.errors.video }}</div>
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
                <div class="col-6">
                  <div class="form-group">
                    <label for="primary">Navigasi</label>
                      <input
                          type="color"
                          class="form-control"
                          v-model="form.primary"
                          :class="{'is-invalid': form.errors.primary}"
                          id="primary"
                          name="primary" />
                      <div v-if="form.errors.primary" class="invalid-feedback">{{ form.errors.primary }}</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="secondary">Footer</label>
                      <input
                          type="color"
                          class="form-control"
                          v-model="form.secondary"
                          :class="{'is-invalid': form.errors.secondary}"
                          id="secondary"
                          name="secondary" />
                      <div v-if="form.errors.secondary" class="invalid-feedback">{{ form.errors.secondary }}</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="background">Background</label>
                      <input
                          type="color"
                          class="form-control"
                          v-model="form.background"
                          :class="{'is-invalid': form.errors.background}"
                          id="background"
                          name="background" />
                      <div v-if="form.errors.background" class="invalid-feedback">{{ form.errors.background }}</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="accent">Accent</label>
                      <input
                          type="color"
                          class="form-control"
                          v-model="form.accent"
                          :class="{'is-invalid': form.errors.accent}"
                          id="accent"
                          name="accent" />
                      <div v-if="form.errors.accent" class="invalid-feedback">{{ form.errors.accent }}</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="text">Teks</label>
                      <input
                          type="color"
                          class="form-control"
                          v-model="form.text"
                          :class="{'is-invalid': form.errors.text}"
                          id="text"
                          name="text" />
                      <div v-if="form.errors.text" class="invalid-feedback">{{ form.errors.text }}</div>
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
import { Link, useForm } from '@inertiajs/vue3';
import { toRefs } from 'vue';

const props = defineProps({
  setting: Object,
});

const { setting } = toRefs(props);

const form = useForm({
  instansi: setting.value?.instansi || '',
  logo: setting.value?.logo || '',
  address: setting.value?.address || '',
  phone: setting.value?.phone || '',
  email: setting.value?.email || '',
  running_text: setting.value?.running_text || '',
  video: setting.value?.video || '',
  primary: setting.value?.primary || '',
  secondary: setting.value?.secondary || '',
  accent: setting.value?.accent || '',
  background: setting.value?.background || '',
  text: setting.value?.text || ''
});

const logoPreview = ref(null);

const submit = () => {
  const formData = new FormData();

  for (const key in form) {
    if (form[key] instanceof File) {
      formData.append(key, form[key]);
    } else {
      formData.append(key, form[key]); 
    }
  }

  form.post('/setting', {
    data: formData,
    onSuccess: () => form.reset(),
    headers: { 'Content-Type': 'multipart/form-data' }
  });
};
const previewImage = (event) => {
  const file = event.target.files[0];
  const reader = new FileReader();

  reader.onload = (e) => {
    logoPreview.value = e.target.result;
  };

  reader.readAsDataURL(file);
  form.logo = file;
};
</script>


<script>
import Dasboard from '../../Layout/Dasboard.vue';

export default {
  layout: (h, page) => h(Dasboard, [page]),

  layout: Dasboard,
}
</script>

<style>
</style>