<script setup>
const props = defineProps({
    data: Object,
});
</script>

<template>
    <div
        v-if="
            data.type === 'perDay' ||
            data.type === 'perMonth' ||
            data.type === 'perYear'
        "
        class="lg:w-2/3 w-full mx-auto overflow-auto"
    >
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                    >
                        年月日
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        金額
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data">
                    <td class="px-4 py-3">
                        {{ item.date }}
                    </td>
                    <td class="px-4 py-3">
                        {{ item.total }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div
        v-if="data.type === 'decile'"
        class="lg:w-2/3 w-full mx-auto overflow-auto"
    >
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                    >
                        グループ
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        平均
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        合計金額
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        構成比
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data">
                    <td class="px-4 py-3">
                        {{ item.decile }}
                    </td>
                    <td class="px-4 py-3">
                        {{ item.average }}
                    </td>
                    <td class="px-4 py-3">
                        {{ item.totalPerGroup }}
                    </td>
                    <td class="px-4 py-3">
                        {{ item.totalRatio }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div
        v-if="data.type === 'rfm'"
        class="lg:w-2/3 w-full mx-auto overflow-auto"
    >
        {{ data.totals }}
        <table class="mx-auto">
            <thead>
                <tr>
                    <th>ランク</th>
                    <th>R (○日以内)</th>
                    <th>F (○回以上)</th>
                    <th>M (○円以上)</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="rfm in data.eachCount" :key="rfm.rank">
                    <td>{{ rfm.rank }}</td>
                    <td>{{ rfm.r }}</td>
                    <td>{{ rfm.f }}</td>
                    <td>{{ rfm.m }}</td>
                </tr>
            </tbody>
        </table>
        <table class="mx-auto">
            <thead>
                <tr>
                    <th>rRank</th>
                    <th>f_5</th>
                    <th>f_4</th>
                    <th>f_3</th>
                    <th>f_2</th>
                    <th>f_1</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="rf in data.data" :key="rf.rRank">
                    <td>{{ rf.rRank }}</td>
                    <td>{{ rf.f_5 }}</td>
                    <td>{{ rf.f_4 }}</td>
                    <td>{{ rf.f_3 }}</td>
                    <td>{{ rf.f_2 }}</td>
                    <td>{{ rf.f_1 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
