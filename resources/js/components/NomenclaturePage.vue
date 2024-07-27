<template>
    <div class="nomenclature-page">
        <div class="main-container">
            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th class="scroll-column"></th>
                        <th class="name-header">Наименование</th>
                        <th>Кол-во</th>
                        <th>Источник</th>
                        <th>Лазер</th>
                        <th>Сварка</th>
                        <th>Сборка</th>
                        <th>Электр</th>
                        <th class="actions-column"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="(item, index) in nomenclatureItems" :key="item.id">
                        <tr :class="{ 'expanded': item.expanded, 'parent-row': true }">
                            <td class="scroll-column">
                                <div class="scroll-buttons">
                                    <button class="scroll-button up" :class="{ 'disabled': index === 0 }" @click="moveItem(index, 'up')">▲</button>
                                    <button class="scroll-button down" :class="{ 'disabled': index === nomenclatureItems.length - 1 }" @click="moveItem(index, 'down')">▼</button>
                                </div>
                            </td>
                            <td>
                                <span class="expand-icon" v-if="hasChildItems(item)" @click="toggleExpand(item)">
                                    {{ item.expanded ? '▼' : '▶' }}
                                </span>
                                {{ item.name }}
                            </td>
                            <td>
                                <div class="quantity-display">{{ item.quantity }}</div>
                            </td>
                            <td>{{ item.source }}</td>
                            <td>{{ item.laser }}</td>
                            <td>{{ item.welding }}</td>
                            <td>{{ item.assembly }}</td>
                            <td>{{ item.electrical }}</td>
                            <td class="actions-column">
                                <button class="icon-button search">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button class="icon-button delete" @click="deleteItem(item)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button class="icon-button add" @click="openAddChildModal(item)">+</button>
                            </td>
                        </tr>
                        <tr v-if="item.expanded" v-for="child in getChildItems(item)" :key="child.id" class="child-row">
                            <td class="scroll-column"></td>
                            <td class="child-name">{{ child.name }}</td>
                            <td class="child-quantity">{{ child.quantity }}</td>
                            <td>{{ child.source }}</td>
                            <td>{{ child.laser }}</td>
                            <td>{{ child.welding }}</td>
                            <td>{{ child.assembly }}</td>
                            <td>{{ child.electrical }}</td>
                            <td class="actions-column">
                                <button class="icon-button search">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button class="icon-button delete" @click="deleteChildItem(item, child)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
            <button class="add-button" @click="showModal = true">Добавить</button>
        </div>

        <!-- Модальное окно для добавления записи в основную таблицу -->
        <div class="modal" v-if="showModal">
            <div class="modal-content">
                <span class="close" @click="showModal = false">&times;</span>
                <h2>Добавить новую запись</h2>
                <form @submit.prevent="saveItem">
                    <div>
                        <label for="name">Наименование:</label>
                        <input type="text" id="name" v-model="newItem.name" required>
                    </div>
                    <div>
                        <label for="quantity">Количество:</label>
                        <input type="number" id="quantity" v-model="newItem.quantity" required>
                    </div>
                    <div>
                        <label for="source">Источник:</label>
                        <input type="text" id="source" v-model="newItem.source" required>
                    </div>
                    <div>
                        <label for="laser">Лазер:</label>
                        <input type="number" id="laser" v-model="newItem.laser">
                    </div>
                    <div>
                        <label for="welding">Сварка:</label>
                        <input type="number" id="welding" v-model="newItem.welding">
                    </div>
                    <div>
                        <label for="assembly">Сборка:</label>
                        <input type="number" id="assembly" v-model="newItem.assembly">
                    </div>
                    <div>
                        <label for="electrical">Электр:</label>
                        <input type="number" id="electrical" v-model="newItem.electrical">
                    </div>
                    <button type="submit" class="save-button">Сохранить</button>
                    <button type="button" class="cancel-button" @click="showModal = false">Отмена</button>
                </form>
            </div>
        </div>

        <!-- Модальное окно для добавления записи в дочернюю таблицу -->
        <div class="modal" v-if="showChildModal">
            <div class="modal-content">
                <span class="close" @click="showChildModal = false">&times;</span>
                <h2>Добавить новую запись в дочернюю таблицу</h2>
                <form @submit.prevent="saveChildItem">
                    <div>
                        <label for="childName">Наименование:</label>
                        <input type="text" id="childName" v-model="newChildItem.name" required>
                    </div>
                    <div>
                        <label for="childQuantity">Количество:</label>
                        <input type="number" id="childQuantity" v-model="newChildItem.quantity" required>
                    </div>
                    <div>
                        <label for="childSource">Источник:</label>
                        <input type="text" id="childSource" v-model="newChildItem.source" required>
                    </div>
                    <div>
                        <label for="childLaser">Лазер:</label>
                        <input type="number" id="childLaser" v-model="newChildItem.laser">
                    </div>
                    <div>
                        <label for="childWelding">Сварка:</label>
                        <input type="number" id="childWelding" v-model="newChildItem.welding">
                    </div>
                    <div>
                        <label for="childAssembly">Сборка:</label>
                        <input type="number" id="childAssembly" v-model="newChildItem.assembly">
                    </div>
                    <div>
                        <label for="childElectrical">Электр:</label>
                        <input type="number" id="childElectrical" v-model="newChildItem.electrical">
                    </div>
                    <button type="submit" class="save-button">Сохранить</button>
                    <button type="button" class="cancel-button" @click="showChildModal = false">Отмена</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            nomenclatureItems: [],
            showModal: false,
            showChildModal: false,
            newItem: {
                name: '',
                quantity: 0,
                source: '',
                laser: null,
                welding: null,
                assembly: null,
                electrical: null
            },
            newChildItem: {
                name: '',
                quantity: 0,
                source: '',
                laser: null,
                welding: null,
                assembly: null,
                electrical: null
            },
            currentParentItem: null
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios.get('/api/nomenclature')
                .then(response => {
                    this.nomenclatureItems = response.data.map(item => ({
                        ...item,
                        expanded: false,
                        child_items: item.child_items || item.childItems || []
                    }));
                    console.log('Fetched ', this.nomenclatureItems); // Для отладки
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        hasChildItems(item) {
            return (item.child_items && item.child_items.length > 0) || (item.childItems && item.childItems.length > 0);
        },
        getChildItems(item) {
            return item.child_items || item.childItems || [];
        },
        toggleExpand(item) {
            item.expanded = !item.expanded;
        },
        moveItem(index, direction) {
            if (direction === 'up' && index > 0) {
                this.swapItems(index, index - 1);
            } else if (direction === 'down' && index < this.nomenclatureItems.length - 1) {
                this.swapItems(index, index + 1);
            }
            this.updatePositions();
        },
        swapItems(index1, index2) {
            const temp = this.nomenclatureItems[index1];
            this.nomenclatureItems[index1] = this.nomenclatureItems[index2];
            this.nomenclatureItems[index2] = temp;
        },
        updatePositions() {
            this.nomenclatureItems.forEach((item, index) => {
                axios.put(`/api/nomenclature/${item.id}`, {position: index})
                    .catch(error => {
                        console.error('Error updating position:', error);
                    });
            });
        },
        deleteItem(item) {
            axios.delete(`/api/nomenclature/${item.id}`)
                .then(() => {
                    this.nomenclatureItems = this.nomenclatureItems.filter(i => i.id !== item.id);
                })
                .catch(error => {
                    console.error('Error deleting item:', error);
                });
        },
        deleteChildItem(parent, child) {
            axios.delete(`/api/nomenclature/${parent.id}/child/${child.id}`)
                .then(() => {
                    parent.child_items = parent.child_items.filter(c => c.id !== child.id);
                })
                .catch(error => {
                    console.error('Error deleting child item:', error);
                });
        },
        saveItem() {
            axios.post('/api/nomenclature', this.newItem)
                .then(response => {
                    this.nomenclatureItems.push(response.data);
                    this.showModal = false;
                    this.newItem = {
                        name: '',
                        quantity: 0,
                        source: '',
                        laser: null,
                        welding: null,
                        assembly: null,
                        electrical: null
                    };
                })
                .catch(error => {
                    console.error('Error saving item:', error);
                });
        },
        openAddChildModal(parentItem) {
            this.currentParentItem = parentItem;
            this.showChildModal = true;
        },
        saveChildItem() {
            axios.post(`/nomenclature/${this.currentParentItem.id}/child`, this.newChildItem)
                .then(response => {
                    this.currentParentItem.child_items.push(response.data);
                    this.showChildModal = false;
                    this.newChildItem = {
                        name: '',
                        quantity: 0,
                        source: '',
                        laser: null,
                        welding: null,
                        assembly: null,
                        electrical: null,
                    };
                })
                .catch(error => {
                    console.error('Бля, у тебя ошибка вот тут!!!!! - :', error);
                });
        }
    }
}
</script>

<style scoped>
.nomenclature-page {
    width: 1200px;
    height: 835px;
    padding: 34px 20px;
    background: #F8FAFC;
    font-family: Inter, sans-serif;
}

.main-container {
    width: 1160px;
    height: 767px;
    background: white;
    overflow: hidden;
    position: relative;
}

.table-wrapper {
    max-height: 767px;
    overflow-y: scroll;
    scrollbar-width: thin;
    scrollbar-color: #6B7280 #F3F4F6;
    margin-left: 8px;
}

.table-wrapper::-webkit-scrollbar {
    width: 8px;
}

.table-wrapper::-webkit-scrollbar-track {
    background: #F3F4F6;
}

.table-wrapper::-webkit-scrollbar-thumb {
    background-color: #6B7280;
    border-radius: 4px;
    border: 2px solid #F3F4F6;
}

table {
    width: calc(100% - 8px);
    border-collapse: separate;
    border-spacing: 0 8px;
}

th {
    font-family: Gilroy, sans-serif;
    font-size: 14px;
    font-weight: 700;
    line-height: 17.33px;
    text-align: left;
    padding: 10px;
    color: #000000;
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
}

.name-header {
    width: 300px;
}

td {
    font-size: 12px;
    font-weight: 400;
    line-height: 14.52px;
    text-align: left;
    padding: 10px;
    color: #000000;
}

.parent-row {
    background: #F8FAFC;
}

.child-row {
    background: white;
    border: none;
    position: relative;
    margin-bottom: 2px; /* Уменьшаем расстояние между строками */
}

.child-row td {
    border: none;
}

.child-row::after {
    content: '';
    position: absolute;
    width: calc(100% - 30px); /* Учитываем ширину столбца для кнопок прокрутки */
    height: 100%;
    top: 0;
    left: 26px; /* Смещаем контур на ширину столбца для кнопок прокрутки */
    border-radius: 8px;
    border: 1px solid #ADADAD;
    opacity: 0px;
    pointer-events: none;
}

.expand-icon {
    cursor: pointer;
    margin-right: 5px;
}

input[type="text"], input[type="number"] {
    width: 100%;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 5px;
}

.icon-button {
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.icon-button.search {
    background-color: #818cf8;
    vertical-align: middle;
}

.icon-button.delete {
    background-color: #ef4444;
    vertical-align: middle;
}

.icon-button.add {
    background-color: green;
    color: white;
    vertical-align: middle;
}

.icon-button svg {
    width: 16px;
    height: 16px;
    color: white;
}

.scroll-column {
    width: 16px;
    padding-right: 5px;
}

.scroll-buttons {
    display: flex;
    flex-direction: column;
    height: 100%;
    justify-content: center;
    background: #F8FAFC;
    border: none;
    width: 16px;
    height: 27px;
    top: 375px;
    left: 48px;
    gap: 0px;
    opacity: 0px;
}

.scroll-button {
    width: 16px;
    height: 16px;
    top: 133px;
    left: 48px;
    gap: 0px;
    opacity: 0px;
    background: #F8FAFC;
    color: #7843E9;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    margin-bottom: 2px;
}

.scroll-button.disabled {
    color: #C4ABFB;
    cursor: not-allowed;
}

.scroll-button:last-child {
    margin-bottom: 0;
}

.actions-column {
    text-align: right;
    padding-right: 15px;
}

.child-name {
    padding-left: 25px;
}

.child-quantity {
    text-align: center;
}

.add-button {
    background-color: green;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    position: relative;
}
.quantity-display {
    width: 24px;
    height: 24px;
    top: 108px;
    left: 408px;
    gap: 0px;
    border-radius: 4px 4px 4px 4px;
    opacity: 0px;
    border: 1px solid #ADADAD;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #000000;
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.save-button, .cancel-button {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

.save-button {
    background-color: green;
    color: white;
    margin-right: 10px;
}

.cancel-button {
    background-color: red;
    color: white;
}
</style>
