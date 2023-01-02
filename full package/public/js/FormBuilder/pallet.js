import React, { Component }  from 'react';
import { Container, Draggable } from 'react-smooth-dnd';
import { applyDrag } from './utils';
import { TheField } from './field';

export default class Pallet extends Component {
	constructor() {
		super();

		this.state = {
			fields: [
				{ id: 1, type: 'input', label: 'Input field', isRequired: false, additionalConfig: {inputType: 'text'} },
				{ id: 2, type: 'date', label: 'Datepicker', isRequired: false, additionalConfig: {} },
				{ id: 3, type: 'select', label: 'Drop-down list', isRequired: false, additionalConfig: {listOptions: ""} },
				{ id: 4, type: 'textarea', label: 'Textarea', isRequired: false, additionalConfig: {textAreaRows: 3} }
			]
		}
	}

  render() {
    return (
		<div className="col">
			<div className="card text-white mb-3" style={{backgroundColor: "#495057"}}>
				<div className="card-header">PALLET</div>
				<div className="card-body">
					<div className="d-flex ml-3 mr-3">
						<Container groupName="1" dragHandleSelector=".column-drag-handle" dragClass="opacity-ghost" dropClass="opacity-ghost-drop" behaviour="copy" getChildPayload={i => this.state.fields[i]} onDrop={e => this.setState({ fields: applyDrag(this.state.fields, e) })}>
						{
							this.state.fields.map((fld,i) => {
								return (
									<Draggable key={fld.id}>
										<div className="draggable-pallet-item">
											<span className="column-drag-handle" style={{float:'left', padding:'0 10px'}}>&#x2630;</span>
											
											{<TheField field={fld} isBoard={false} />}
										</div>
									</Draggable>
								);
							})
						}
						</Container>
					</div>
        		</div>
        	</div>
        </div>
    );
  }
}
