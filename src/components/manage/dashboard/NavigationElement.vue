<template>
    <li
        v-on:mouseover="showChildren = true"
        v-on:mouseout="showChildren = false"
    >
        <a
            v-bind:class="{
                'mainfoldericon': linkClass === 'main',
                'subfoldericon': linkClass === 'sub'
            }"
            v-bind:href="menuItemLink"
            v-on:click="clickLink($event)"
            v-bind:target="menuItemBlank ? '_blank' : '_self'"
        >{{ elementName }}</a>
        <ul v-if="menuItemChildren.length" v-visible="showChildren">
            <navigation-element
                v-for="childItem in menuItemChildren"
                v-if="resolveCondition(childItem.shouldParse)"
                v-bind:menu-item="childItem"
                v-bind:first-level="false"
                v-bind:key="childItem.name"
            ></navigation-element>
        </ul>
        <ul v-else-if="menuItem.childrenFrom" v-visible="showChildren">
            <li v-for="childFrom in getChildrenFrom(menuItem.childrenFrom)">
                <a class="submenu_item" v-bind:href="menuItemLink + '/' + childFrom[menuItem.childId]">{{ childFrom[menuItem.childName] }}</a>
            </li>
        </ul>
    </li>
</template>

<script src="./NavigationElement.js"></script>

<style src="../../../assets/css/manage/dashboard/navigation-element.css" scoped></style>
