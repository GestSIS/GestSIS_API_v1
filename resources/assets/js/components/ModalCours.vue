<template>
    <div id="modal-cours" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form role="form">
                <div class="card-header">
                <h3>Paramètres pour la saisie d'un cours</h3>
                </div>
                <div class="card-body">
                <div class="form-group">
                    <label for="cours-name">Cours</label>
                    <select id="cours-name" v-model="selectedCours" class="form-control">
                        <option v-for="_cours in coursData" :value="_cours.id" >{{ _cours.nom }}</option>
                    <!-- TODO limiter le nombre de cours -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="cours-date">Date du cours</label>
                    <input type="date" class="form-control" id="cours-date">
                </div>
                <div class="form-group">
                    <label for="cours-localite">Cours</label>
                    <select id="cours-localite" class="form-control">
                    <option>Saulcy</option>
                    <option>Glovelier</option>
                    <option>Bassecourt</option>
                    <option>Courfaivre</option>
                    <option>Boécourt</option>
                    <!-- TODO Lister les localités -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="cours-precedent">Cours précédent</label>
                    <select id="cours-precedent" v-model="cou_pre_id" class="form-control">
                        <option v-for="_cours in coursData" :value="_cours.id" >{{ _cours.nom }}</option>
                    <!-- Limiter le nombre de cours -->
                    </select>
                </div>
                <div class="form-group">
                    <label>Grade</label>
                </div>
                <div class="row">
                    <div class="col-md-8">
                    <div class="form-group">
                        <select v-model="gra_id" class="form-control select" data-placeholder="Select a State" tabindex="-1">
                            <option v-for="_grade in gradeData" :value="_grade.id" >{{ _grade.nom }}</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                    <div class="form-group">
                        <input type="date" class="form-control">
                    </div>
                    <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="form-group">
                    <label>Fonction</label>
                </div>
                <div class="row">
                    <div class="col-md-8">
                    <div class="form-group">
                        <select v-model="fon_id" class="form-control select" disabled>
                            <option v-for="_fonction in fonctionData" :value="_fonction.id" >{{ _fonction.nom }}</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                    <div class="form-group">
                        <input type="date" class="form-control">
                    </div>
                    <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="form-group">
                    <label>Fonction remplacé</label>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <!-- TODO Add v-model with the current grade of the sapeur -->
                            <select class="form-control" disabled>
                                <option v-for="_fonction in fonctionData" :value="_fonction.id" >{{ _fonction.nom }}</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                <button type="submit" class="btn btn-secondary">Annuler</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        props: ['coursData', 'fonctionData', 'gradeData'],
        data:function () {
            return {
                selectedCours: 0,
                fonction: {},
                grade: {},
                cours: {},
                gra_id: 0,
                fon_id: 0,
                cou_pre_id: 0
            }
        },
        mounted() {
            this.selectedCours = 1;
        },
        watch: {
            selectedCours: function(newOne, oldOne){
                this.cours = this.coursData.filter((elt)=>{return elt.id == newOne})[0];
                let id_fon = this.fon_id = this.cours.id_fon;
                let id_gra = this.gra_id = this.cours.id_gra;
                this.cou_pre_id = this.cours.prec;
                if(id_gra > 0){
                    this.grade = this.gradeData.filter((elt)=>{return elt.id == id_gra})[0];
                }
                if(id_fon > 0){
                    this.fonction = this.fonctionData.filter((elt)=>{return elt.id == id_fon})[0];
                }
            }
        }
    }
</script>