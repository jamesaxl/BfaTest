<?php

use Illuminate\Database\Seeder;

class DocumentSubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('document_sub_types')->insert([
            [
                'name' => 'country strategy document',
                'document_type_id' => '1',
            ],
            [
                'name' => 'regional integration strategy',
                'document_type_id' => '1',
            ],
            [
                'name' => 'national Strategy',
                'document_type_id' => '1',
            ],
            [
                'name' => 'sector strategy',
                'document_type_id' => '1',
            ],
            [
                'name' => 'sector policy',
                'document_type_id' => '1',
            ],
            [
                'name' => 'rule',
                'document_type_id' => '2',
            ],
            [
                'name' => 'manual',
                'document_type_id' => '2',
            ],
            [
                'name' => 'presidential directive',
                'document_type_id' => '2',
            ],
            [
                'name' => 'financial regulations',
                'document_type_id' => '2',
            ],
            [
                'name' => 'terms and conditions',
                'document_type_id' => '3',
            ],
            [
                'name' => 'soft',
                'document_type_id' => '3',
            ],
            [
                'name' => 'project agreement',
                'document_type_id' => '3',
            ],
            [
                'name' => 'individual consultant contract',
                'document_type_id' => '3',
            ],
            [
                'name' => 'design office contract',
                'document_type_id' => '3',
            ],
            [
                'name' => 'company contract',
                'document_type_id' => '3',
            ],
            [
                'name' => 'supplier contract',
                'document_type_id' => '3',
            ],
            [
                'name' => 'rule',
                'document_type_id' => '4',
            ],
            [
                'name' => 'manual',
                'document_type_id' => '4',
            ],
            [
                'name' => 'presidential directive',
                'document_type_id' => '4',
            ],
            [
                'name' => 'financial regulations',
                'document_type_id' => '4',
            ],
            [
                'name' => 'feasibility study',
                'document_type_id' => '5',
            ],
            [
                'name' => 'preliminary draft',
                'document_type_id' => '5',
            ],
            [
                'name' => 'petailed pre-project',
                'document_type_id' => '5',
            ],
            [
                'name' => 'project concept note (PCN)',
                'document_type_id' => '5',
            ],
            [
                'name' => 'project evaluation report (PAR)',
                'document_type_id' => '5',
            ],
            [
                'name' => 'PAR annexes',
                'document_type_id' => '5',
            ],
            [
                'name' => 'procurement plan',
                'document_type_id' => '5',
            ],
            [
                'name' => 'completion report',
                'document_type_id' => '5',
            ],
            [
                'name' => 'abstract environmental and social impact study',
                'document_type_id' => '5',
            ],
            [
                'name' => 'environmental and social impact study',
                'document_type_id' => '5',
            ],
            [
                'name' => 'MIC assessment report',
                'document_type_id' => '5',
            ],
            [
                'name' => 'project additionality Report (ADOA)',
                'document_type_id' => '5',
            ],
            [
                'name' => 'project risk report',
                'document_type_id' => '5',
            ],
            [
                'name' => 'work plan and budget',
                'document_type_id' => '5',
            ],
            [
                'name' => 'economic studies',
                'document_type_id' => '6',
            ],
            [
                'name' => 'sector studies',
                'document_type_id' => '6',
            ],
            [
                'name' => 'works and supplies',
                'document_type_id' => '7',
            ],
            [
                'name' => 'standard tender documents',
                'document_type_id' => '7',
            ],
            [
                'name' => 'customer references',
                'document_type_id' => '7',
            ],
            [
                'name' => 'notice of Calls for tenders',
                'document_type_id' => '7',
            ],
            [
                'name' => 'validated Call for tender files',
                'document_type_id' => '7',
            ],
            [
                'name' => 'technical specifications (for each type of activity)',
                'document_type_id' => '7',
            ],
            [
                'name' => 'country bid evaluation reports',
                'document_type_id' => '7',
            ],
            [
                'name' => 'no objection memos',
                'document_type_id' => '7',
            ],
            [
                'name' => 'firm consultants',
                'document_type_id' => '7',
            ],
            [
                'name' => 'standard tender documents',
                'document_type_id' => '7',
            ],
            [
                'name' => 'customer references',
                'document_type_id' => '7',
            ],
            [
                'name' => 'notice of expression of interest',
                'document_type_id' => '7',
            ],
            [
                'name' => 'requests for proposals',
                'document_type_id' => '7',
            ],
            [
                'name' => 'terms of reference',
                'document_type_id' => '7',
            ],
            [
                'name' => 'proposed methodologies',
                'document_type_id' => '7',
            ],
            [
                'name' => 'minutes of negotiations',
                'document_type_id' => '7',
            ],
            [
                'name' => 'technical and financial bid evaluation reports',
                'document_type_id' => '7',
            ],
            [
                'name' => 'no objection memos',
                'document_type_id' => '7',
            ],
            [
                'name' => 'individual consultants',
                'document_type_id' => '7',
            ],
            [
                'name' => 'standard tender documents',
                'document_type_id' => '7',
            ],
            [
                'name' => 'standard tender documents',
                'document_type_id' => '7',
            ],
            [
                'name' => 'letters of invitation',
                'document_type_id' => '7',
            ],
            [
                'name' => 'bids evaluation reports',
                'document_type_id' => '7',
            ],
            [
                'name' => 'negotiated contracts',
                'document_type_id' => '7',
            ],
            [
                'name' => 'other document',
                'document_type_id' => '8',
            ],
        ]);
    }
}
